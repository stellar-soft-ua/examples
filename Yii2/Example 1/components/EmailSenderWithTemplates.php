<?php

    namespace app\components;


    use app\models\EmailHistory;
    use app\models\EmailTemplate;
    use app\models\User;
    use ReflectionException;
    use yii\base\Exception;
    use yii\helpers\Json;

    class EmailSenderWithTemplates extends EmailSender
    {
        public    $view                = 'views/main';
        protected $layout              = null;
        protected $params              = [];
        protected $templateModel       = null;
        protected $templateMachineName = null;

        /**
         * Sends Email
         *
         * @param $userID
         * @param $templateMachineName
         *
         * @return bool
         */
        public function sendUsingTemplate($userID, $templateMachineName) {

            $this->userID              = $userID;
            $this->templateMachineName = $templateMachineName;

            try {
                $this->loadModels();

                $this->loadAttributes();

                $this->composeWithTemplate();

            } catch (\Exception $exception) {
                $this->logException($exception->getMessage());

            }

            return $this->isSuccess;
        }

        /**
         * Load Models
         *
         * @throws Exception
         */
        protected function loadModels() {

            $this->userModel = User::findOne($this->userID);
            if (!$this->userModel) throw new Exception('User Model for userID: ' . $this->userID . ' is not found.');

            $this->templateModel = EmailTemplate::find()->where(['machine_name' => $this->templateMachineName])->one();
            if (!$this->templateModel) throw new Exception('Template Model for templateMachineName: ' . $this->templateMachineName . ' is not found.');
        }

        /**
         * Load Attributes
         */
        protected function loadAttributes() {
            $fromName      = $this->params ? $this->templateModel->replacePlaceholders($this->templateModel->from_name, $this->params) : $this->templateModel->from_name;
            $this->from    = [$this->templateModel->from_email => $fromName];
            $this->to      = [isset($this->params['emailTo']) && $this->params['emailTo'] ? $this->params['emailTo'] : $this->userModel->email];
            $this->subject = $this->params ? $this->templateModel->replacePlaceholders($this->templateModel->subject, $this->params) : $this->templateModel->subject;
            $this->body    = $this->params ? $this->templateModel->replacePlaceholders($this->templateModel->content, $this->params) : $this->templateModel->content;
        }

        /**
         * Compose email
         *
         * @throws ReflectionException
         */
        protected function composeWithTemplate() {

            $this->compose($this->view, ['content' => $this->body])
                 ->setFrom($this->from)
                 ->setTo($this->to)
                 ->setSubject($this->subject)
                 ->setUserID($this->userID)
                 ->send()
                 ->saveHistory($this->templateMachineName);
        }

        /**
         * Log Exception
         *
         * @param $exception
         */
        protected function logException($exception) {
            $emailHistory                 = new EmailHistory();
            $emailHistory->from           = $this->from ? Json::encode($this->from) : null;
            $emailHistory->to             = $this->to ? Json::encode($this->to) : null;
            $emailHistory->subject        = $this->subject;
            $emailHistory->body           = $this->body;
            $emailHistory->request_uniqid = uniqid();
            $emailHistory->created        = DateFactory::component()->getNOW();
            $emailHistory->type           = $this->templateMachineName;
            $emailHistory->server         = $this->server;
            $emailHistory->user_id        = $this->userID;
            $emailHistory->sent_status    = self::STATUS_FAILED;
            $emailHistory->reject_reason  = $exception;
            $emailHistory->save(false);
        }

        /**
         * Set Params
         *
         * @param array $params
         *
         * @return $this
         */
        public function setParams(array $params) {
            $this->params = $params;

            return $this;
        }

        /**
         * Set Template Layout
         *
         * @param $layout
         *
         * @return $this
         */
        public function setTemplateLayout($layout) {
            $this->layout = $layout;

            return $this;
        }

        /**
         * Set email used view
         *
         * @param $view
         */
        public function setView($view) {
            $this->view = $view;
        }

    }