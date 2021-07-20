<?php

    namespace app\modules\translateManager;

    use lajax\translatemanager\Module;
    use ReflectionException;
    use Yii;
    use yii\base\UserException;
    use yii\filters\AccessControl;

    /**
     * translate manager module definition class
     */
    class TranslateManager extends Module
    {
        /**
         * Behavior
         *
         * @return array
         */
        public function behaviors() {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow'        => !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin(),
                            'denyCallback' => function ($rule, $action) {
                                if (Yii::$app->user->isGuest) {
                                    return $action->controller->redirect(['/']);
                                } else {
                                    throw new UserException(Yii::t('admin', 'Invalid Request'));
                                }
                            }
                        ]
                    ],
                ],
            ];
        }

        /**
         * Returns view path
         *
         * @return string
         * @throws ReflectionException
         */
        public function getViewPath() {
            return Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'translateManager' . DIRECTORY_SEPARATOR . 'views';
        }
    }
