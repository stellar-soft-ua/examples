<?php

    namespace app\modules\admin\controllers;

    use app\components\Base\Modules\AdminController;
    use app\modules\api\models\ApiLogRequest;
    use app\modules\api\models\search\ApiLogRequestSearch;
    use Exception;
    use Throwable;
    use Yii;
    use yii\helpers\ArrayHelper;
    use yii\web\NotFoundHttpException;

    class ApiHistoryController extends AdminController
    {
        /**
         * @return array
         */
        public function behaviors() {
            return ArrayHelper::merge(parent::behaviors(), []);
        }

        /**
         * @return string
         */
        public function actionIndex() {
            $searchModel  = new ApiLogRequestSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        /**
         * @param $id
         * @param $type
         *
         * @return string
         */
        public function actionAjaxViewLogRequest($id, $type) {

            $logRequest = ApiLogRequest::findOne($id);

            return empty($logRequest->{$type}) ? '' : nl2br(str_replace(['\\n', ' '], ["\n", '&nbsp;'], gzinflate($logRequest->{$type})));
        }

        /**
         * @param $id
         *
         * @return string
         * @throws Throwable
         */
        public function actionAjaxDelete($id) {
            $this->setJsonFormatResponse();
            try {
                $model = $this->findModel($id);
                $model->delete();

                Yii::$app->session->setFlash(self::ALERT_SUCCESS, Yii::t('admin', 'Log has been deleted.'));
            } catch (Exception $e) {
                Yii::$app->session->setFlash(self::ALERT_DANGER, Yii::$app->params['systemErrorMessage']);
            }
        }

        /**
         * @param $id
         *
         * @return null|static
         * @throws NotFoundHttpException
         */
        protected function findModel($id) {
            if (($model = ApiLogRequest::findOne($id)) !== null) {
                return $model;
            }

            throw new NotFoundHttpException(Yii::t('admin', 'The requested page does not exist.'));
        }
    }
