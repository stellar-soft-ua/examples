<?php

    namespace app\modules\api\controllers;

    use app\models\User;
    use app\modules\api\models\ApiLogRequest;
    use Yii;
    use yii\base\Action;
    use yii\base\InvalidConfigException;
    use yii\base\InvalidParamException;
    use yii\filters\auth\HttpBasicAuth;
    use yii\helpers\Json;
    use yii\web\BadRequestHttpException;
    use yii\web\Controller;
    use yii\web\ForbiddenHttpException;
    use yii\web\HttpException;
    use yii\web\MethodNotAllowedHttpException;
    use yii\web\Response;
    use yii\web\UnauthorizedHttpException;

    /**
     * API Rest Base Controller that extend a base controller class
     * This class will be used as base class for all controller from API module
     * Class ApiBaseController
     *
     * @package app\controllers
     */
    abstract class ApiController extends Controller
    {
        public    $layout             = false;
        protected $bodyParams         = [];
        protected $urlParams          = [];
        /** @var User|null $loggedUser */
        protected $loggedUser;
        private   $response           = null;
        private   $responseSuccess    = true;
        private   $responseMessages   = null;
        private   $responseData       = [];
        private   $responseGlobalData = [];
        private   $responseStatusCode = null;
        /** @var null|ApiLogRequest $logRequest */
        private $logRequest        = null;
        private $logRequestStarted = null;

        /**
         * Initialization method
         */
        public function init() {
            $this->logRequestStarted = microtime(true);

            parent::init();
            Yii::$app->errorHandler->errorAction = 'error/api';
            Yii::$app->user->enableSession       = false;
        }

        /**
         * Set controller behaviors
         *
         * @return array
         */
        public function behaviors() {
            $behaviors = parent::behaviors();
            if (Yii::$app->params['ApiEnableHttpBasicAuth'] === true) {
                if ($this->module->authenticationExceptions) {
                    foreach ($this->module->authenticationExceptions as $authException) {
                        if ($authException['controller'] == $this->id && $authException['action'] == $this->action->id) {
                            return $behaviors;
                        }
                    }
                }
                $behaviors['authenticator'] = [
                    'class' => HttpBasicAuth::className(),
                    'auth'  => [$this, 'httpBasicAuth']
                ];
            }

            return $behaviors;
        }

        ///////////////////////////////////////////////////////Events Actions Start///////////////////////////////////////////

        /**
         * @param $action
         *
         * @return bool
         * @throws InvalidConfigException
         * @throws BadRequestHttpException
         */
        public function beforeAction($action) {
            $this->setBodyParams();
            $this->insertLogRequest();
            $this->setResponse();

            return parent::beforeAction($action);
        }

        /**
         * @throws InvalidConfigException
         */
        private function setBodyParams() {
            if ($body = Yii::$app->getRequest()->getRawBody()) {
                try {
                    $this->bodyParams = Json::decode($body);
                } catch (InvalidParamException $e) {
                    $this->bodyParams = Yii::$app->getRequest()->post();
                }

            } elseif ($body = Yii::$app->getRequest()->getBodyParams()) {
                $this->bodyParams = $body;
            }
        }

        /**
         * Insert log request
         */
        private function insertLogRequest() {
            if (isset(Yii::$app->params['ApiLogRequests']) && Yii::$app->params['ApiLogRequests'] == true) {
                $request                     = Yii::$app->request;
                $logRequest                  = new ApiLogRequest();
                $logRequest->request_type    = $request->method;
                $logRequest->request_url     = $request->absoluteUrl;
                $logRequest->controller_name = Yii::$app->controller->id;
                $logRequest->action_name     = Yii::$app->controller->action->id;
                $logRequest->status          = ApiLogRequest::STATUS_STARTED;
                if (!empty($this->bodyParams)) {
                    $logRequest->request_body_params = $this->compressArrayValue($this->bodyParams);
                }
                $logRequest->started_at = date('Y-m-d H:i:s');

                if ($logRequest->save()) {
                    $this->logRequest = $logRequest;
                }
            }
        }
        ///////////////////////////////////////////////////////Events Actions End/////////////////////////////////////////////

        /**
         * Compress value
         *
         * @param $value
         *
         * @return string
         */
        private function compressArrayValue($value) {
            return gzdeflate(Json::encode($value, JSON_PRETTY_PRINT), 6);
        }

        /**
         * Set response default structure an populate with "result" and "data" params
         */
        private function setResponse() {
            $this->response = self::getResponseTemplate($this->responseSuccess, $this->responseMessages, $this->responseData, $this->responseGlobalData);
        }

        /**
         * Returns the response template of the API request
         *
         * @param       $success
         * @param       $message
         * @param       $data
         * @param array $globalData
         *
         * @return array
         */
        public static function getResponseTemplate($success, $message, $data, $globalData = []) {
            $return = [
                'success' => $success,
                'message' => $message,
            ];

            if ($globalData) {
                $return['globalData'] = $globalData;
            }

            $return['data'] = $data;

            return $return;
        }

        /** {@inheritdoc} */
        public function runAction($id, $params = []) {
            try {
                $return = parent::runAction($id, $params);
            } catch (HttpException $e) {
                $this->responseStatusCode = $e->statusCode;
                $this->setErrorMessage($e->getMessage());
                $return = $this->afterAction($this->action, $this->response);
            }

            return $return;
        }

        /**
         * @param $message
         *
         * @return $this
         * @throws HttpException
         */
        protected function setErrorMessage($message) {
            $this->setMessage($message);
            $this->setSuccess(false);

            return $this;
        }

        /**
         * @param $message
         *
         * @return $this
         */
        protected function setMessage($message) {
            $message                = is_string($message) ? trim($message) : $message;
            $this->responseMessages = !empty($message) ? $message : null;

            return $this;
        }

        /**
         * Set success param information
         *
         * @param $isSuccess
         *
         * @return $this
         * @throws HttpException
         */
        protected function setSuccess($isSuccess) {
            if (!is_bool($isSuccess)) {
                throw new HttpException(406, 'resultSuccess param must be boolean');
            }
            $this->responseSuccess = $isSuccess;

            return $this;
        }

        /**
         * @param Action $action
         * @param mixed            $result
         *
         * @return mixed
         */
        public function afterAction($action, $result) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $this->setResponse();
            if ($this->responseStatusCode) {
                Yii::$app->response->setStatusCode($this->responseStatusCode);
            }
            $this->updateLogRequest();

            return parent::afterAction($action, $this->response);
        }

        /**
         * Update Log request
         */
        private function updateLogRequest() {
            if ($this->logRequest) {
                $nowMicroseconds = microtime(true);

                $this->logRequest->status           = $this->responseSuccess ? ApiLogRequest::STATUS_SUCCESS : ApiLogRequest::STATUS_ERROR;
                $this->logRequest->response         = $this->compressArrayValue($this->response);
                $this->logRequest->request_duration = ceil(($nowMicroseconds - $this->logRequestStarted) * 1000); // convert to milliseconds
                $this->logRequest->finished_at      = date('Y-m-d H:i:s');

                $this->logRequest->save();
            }
        }

        /**
         * Run API Rest Authentication before any action
         *
         * @param $username
         * @param $password
         *
         * @return WebUser
         * @throws UnauthorizedHttpException
         */
        public function httpBasicAuth($username, $password) {
            if (empty($username) || empty($password) || $username != Yii::$app->params['ApiBasicAuthUsername'] || $password != Yii::$app->params['ApiBasicAuthPassword']) {
                throw new UnauthorizedHttpException("Authentication failed!");

            } else {
                return new WebUser();
            }
        }

        /**
         * Get response "data" param
         *
         * @return array
         */
        protected function getResponseData() {
            return (array)$this->responseData;
        }

        /**
         * Set response "data" params
         *
         * @param $data
         */
        protected function setResponseData($data) {
            $this->responseData = $data;
        }

        /**
         * Reset response "data" param to an empty array
         */
        protected function resetResponseData() {
            $this->responseData = [];
        }

        /**
         * Add new data to current response "data" param
         *
         * @param array $data
         */
        protected function addResponseData(array $data) {
            $this->responseData = array_merge($this->responseData, $data);
        }

        /**
         * Set response "globalData" params
         *
         * @param $data
         */
        protected function setResponseGlobalData($data) {
            $this->responseGlobalData = $data;
        }

        /**
         * @param array $data
         *
         * @return $this
         * @throws HttpException
         */
        protected function setModelErrorMessages(array $data) {
            $this->setResponseStatusCodeBadRequest();
            $message       = null;
            $count         = 0;
            $errorMessages = [];
            foreach ($data as $dataField => $dataErrors) {
                foreach ($dataErrors as $dataError) {
                    $message         = $dataError;
                    $errorMessages[] = $message;
                    $count++;
                }
            }

            if ($count == 1) {
                $this->setErrorMessage($message);
            }
            if ($count > 1) {
                $this->setErrorMessage($errorMessages);
            }

            return $this;
        }

        /**
         * Set response status code as 400 (Bad Request)
         *
         * @return $this
         */
        public function setResponseStatusCodeBadRequest() {
            $this->setResponseStatusCode(400);

            return $this;
        }

        /**
         * Set response status code
         *
         * @param $statusCode
         *
         * @return $this
         */
        public function setResponseStatusCode($statusCode) {
            $this->responseStatusCode = $statusCode;

            return $this;
        }

        /**
         * Validate action user token
         *
         * @throws ForbiddenHttpException
         * @throws MethodNotAllowedHttpException
         */
        protected function validateActionUserToken() {
            $token = Yii::$app->getRequest()->get('token');
            if (!$token || !$user = User::findOne(['auth_key' => $token, 'active' => User::ACTIVE_TRUE])) {
                throw new ForbiddenHttpException('Invalid hash token!');
            }

            if (!$user->isActive()) {
                throw new MethodNotAllowedHttpException('No valid user token');
            }

            $this->loggedUser = $user;
        }
    }