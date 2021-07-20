<?php

    namespace app\modules\admin;

    use Yii;
    use yii\base\Module;
    use yii\filters\AccessControl;

    /**
     * administration module definition class
     */
    class Admin extends Module
    {
        const URL_MODULE_NAME      = 'admin';
        const MODULE_FRIENDLY_NAME = 'Admin';

        /**
         * {@inheritdoc}
         */
        public $controllerNamespace = 'app\modules\admin\controllers';

        /**
         * Behavior
         *
         * @return array
         */
        public function behaviors() {
            return [
                'access' => [
                    'class'  => AccessControl::className(),
                    'rules'  => [
                        [
                            'allow'        => !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin(),
                            'denyCallback' => function ($rule, $action) {
                                if (Yii::$app->user->isGuest || !Yii::$app->user->identity->isAdmin()) {
                                    return $action->controller->redirect(['/site/login', 'ref' => Yii::$app->request->isAjax ? null : Yii::$app->request->getUrl()]);
                                }
                            }
                        ]
                    ],
                    'except' => [
                    ]
                ],
            ];
        }
    }
