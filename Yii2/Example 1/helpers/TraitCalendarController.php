<?php

    namespace app\helpers;

    use app\components\Base\Core\Controller;
    use app\models\Task;
    use app\widgets\Calendar;
    use Exception;
    use Yii;
    use yii\web\ForbiddenHttpException;
    use yii\web\NotFoundHttpException;

    trait TraitCalendarController
    {
        /** @var Controller $this */

        /**
         * Index action
         *
         * @return string
         */
        public function actionIndex() {
            return $this->render('index', [
                'events' => Calendar::getCalendarEvents()
            ]);
        }

        /**
         * Ajax view event details by type and ID
         *
         * @param $eventType
         * @param $eventID
         *
         * @return string
         */
        public function actionAjaxViewEventDetails($eventType, $eventID) {
            return $this->renderAjax('events/view-' . $eventType, [
                'event' => $this->_getEventByType($eventType, $eventID)
            ]);
        }

        /**
         * Get event by type
         *
         * @param $eventType
         * @param $eventID
         *
         * @return array
         */
        private function _getEventByType($eventType, $eventID) {
            $eventModel   = null;
            $errorMessage = null;
            try {
                switch ($eventType) {
                    case 'task':
                        $eventModel = $this->findTaskModel($eventID);
                        break;
                }
            } catch (Exception $e) {
                $errorMessage = $e->getMessage();
            }


            return ['model' => $eventModel, 'errorMessage' => $errorMessage];
        }

        /**
         * Find task model
         *
         * @param $id
         *
         * @return Task|null
         * @throws ForbiddenHttpException
         * @throws NotFoundHttpException
         */
        private function findTaskModel($id) {
            $task = Task::findOne($id);
            if (!$task) {
                throw new NotFoundHttpException(Yii::t('realtor', 'The requested task does not exist.'));
            }
            if ($task->user_id != Yii::$app->user->id && $task->assigned_user_id != Yii::$app->user->id) {
                throw new ForbiddenHttpException(Yii::t('realtor', 'You are not allowed to see this task.'));
            }

            return $task;
        }

        /**
         * Ajax update event details by type and ID
         *
         * @param $eventType
         * @param $eventID
         *
         * @return string
         */
        public function actionAjaxUpdateEventDetails($eventType, $eventID) {
            return $this->renderAjax('events/' . $eventType, [
                'event' => $this->_getEventByType($eventType, $eventID)
            ]);
        }
    }