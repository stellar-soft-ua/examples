<?php

    namespace app\modules\admin\controllers;

    use Yii;
    use app\models\Category;
    use app\models\search\CategorySearch;
    use app\components\Base\Modules\AdminController;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;

    /**
     * CategoryController implements the CRUD actions for Category model.
     */
    class CategoryController extends AdminController
    {
        /**
         * {@inheritdoc}
         */
        public function behaviors() {
            return [
                'verbs' => [
                    'class'   => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ];
        }

        /**
         * Lists all Category models.
         *
         * @return mixed
         */
        public function actionIndex() {
            $searchModel  = new CategorySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        /**
         * Creates/Updates a Category model.
         *
         * @param null $id
         *
         * @return array|string
         * @throws NotFoundHttpException
         * @throws \Exception
         */
        public function actionAjaxCreateUpdate($id = null) {
            if ($id) {
                $model        = $this->findModel($id);
                $notification = Yii::t('admin', 'Category has been updated.');
            } else {
                $model        = new Category();
                $notification = Yii::t('admin', 'Category has been created.');
            }

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $this->setJsonFormatResponse();
                $model->save();
                Yii::$app->session->setFlash(self::ALERT_SUCCESS, $notification);

                return [
                    'closeModal'    => true,
                    'refreshGridID' => 'category_list_pjax_id'
                ];
            }

            return $this->renderAjax('form', [
                'model' => $model,
            ]);
        }

        /**
         * Deletes an existing Category model.
         *
         * @param $id
         *
         * @throws NotFoundHttpException
         * @throws \Throwable
         * @throws \yii\db\StaleObjectException
         */
        public function actionAjaxDelete($id) {
            $this->setJsonFormatResponse();
            $model = $this->findModel($id);
            if ($model->getRelationByEntityType() || $model->files) {
                Yii::$app->session->setFlash(self::ALERT_ERROR, Yii::t('admin', '"{categoryName}" category cannot be deleted because is already used.', [
                    'categoryName' => $model->name,
                    'filesCount' => count($model->files)
                ]));
            } elseif(is_null($model->machine_name) && $model->delete()) {
                Yii::$app->session->setFlash(self::ALERT_SUCCESS, Yii::t('admin', '"{categoryName}" category has been successfully deleted.', ['categoryName' => $model->name]));
            } else {
                Yii::$app->session->setFlash(self::ALERT_ERROR, Yii::$app->params['systemErrorMessage']);
            }
        }

        /**
         * Ajax change status
         *
         * @param $id
         * @param $value
         *
         * @throws NotFoundHttpException
         */
        public function actionAjaxChangeStatus($id, $value) {
            $this->setJsonFormatResponse();

            $model = $this->findModel($id);
            $model->active = $value;
            $model->save(false, ['active']);

            Yii::$app->session->setFlash(self::ALERT_SUCCESS, Yii::t('admin', 'Category status has been set {status}.', ['status' => Category::getStatuses()[$value]]));
        }

        /**
         * Finds the Category model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         *
         * @param integer $id
         *
         * @return Category the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id) {
            if (($model = Category::findOne($id)) !== null) {
                return $model;
            }

            throw new NotFoundHttpException(Yii::t('admin', 'The requested page does not exist.'));
        }
    }
