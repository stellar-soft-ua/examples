<?php

    namespace app\modules\api\models;

    use app\components\Base\Core\Model;

    /**
     * This is the model class for table "api_log_request".
     *
     * @property integer  $id
     * @property string   $request_type
     * @property resource $request_url
     * @property resource $request_body_params
     * @property resource $controller_name
     * @property resource $action_name
     * @property resource $response
     * @property integer  $request_duration
     * @property string   $status
     * @property string   $started_at
     * @property string   $finished_at
     */
    class ApiLogRequest extends Model
    {
        const STATUS_STARTED = 'started';
        const STATUS_SUCCESS = 'success';
        const STATUS_ERROR   = 'error';

        const HOMEOWNER_REGISTER = 'HOMEOWNER_REGISTER';


        /**
         * @inheritdoc
         */
        public static function tableName() {
            return 'api_log_request';
        }

        public static function getRequests($actionName = null) {
            $requests = [
                self::HOMEOWNER_REGISTER => 'Homeowner Register',
            ];

            $action = ($actionName && isset($requests[$actionName])) ? $requests[$actionName] : 'N/A';

            return ($actionName) ? $action : $requests;
        }

        /**
         * @inheritdoc
         */
        public function rules() {
            return [
                [['request_type', 'request_url', 'started_at'], 'required'],
                [['request_url', 'request_body_params', 'response'], 'string'],
                [['created_at', 'finished_at', 'controller_name', 'action_name', 'status'], 'safe'],
                [['request_duration'], 'integer'],
                [['request_type'], 'string', 'max' => 100],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels() {
            return [
                'id'                  => 'ID',
                'request_type'        => 'Request Type',
                'request_url'         => 'Request Url',
                'request_body_params' => 'Body Params',
                'response'            => 'Response',
                'controller_name'     => 'Controller',
                'action_name'         => 'Action',
                'request_duration'    => 'Duration',
                'status'              => 'Status',
                'started_at'          => 'Started At',
                'finished_at'         => 'Finished At',
            ];
        }

        /**
         * Returns request duration in human readable format ({xx}d {xx}h {xx}m {xx}s {xx}ms)
         *
         * @return null|string
         */
        public function getDurationInReadableFormat() {
            return $this->convertMillisecondsInReadableFormat($this->request_duration);
        }

        /**
         * Convert milliseconds in human readable format ({xx}d {xx}h {xx}m {xx}s {xx}ms)
         *
         * @param        $milliseconds
         * @param null   $limitMaxDisplay
         * @param string $limitMaxDisplayApproximateSuffix
         *
         * @return null|string
         */
        public function convertMillisecondsInReadableFormat($milliseconds, $limitMaxDisplay = null, $limitMaxDisplayApproximateSuffix = '~') {
            $return = null;

            if (is_numeric($milliseconds) && $milliseconds > 0) {
                $dateFormat['d']  = intval(intval($milliseconds / (3600 * 24 * 1000)));
                $dateFormat['h']  = intval($milliseconds / (1000 * 3600)) % 24;
                $dateFormat['m']  = intval($milliseconds / (1000 * 60)) % 60;
                $dateFormat['s']  = intval($milliseconds / 1000) % 60;
                $dateFormat['ms'] = intval($milliseconds) % 1000;

                $firstType = false;
                $counter   = 0;
                foreach ($dateFormat as $type => $value) {
                    if ($value > 0 || true === $firstType) {
                        if ($limitMaxDisplay && $counter == $limitMaxDisplay) {
                            $return = $limitMaxDisplayApproximateSuffix . $return;
                            break;
                        }
                        $return    .= $value . $type . ' ';
                        $firstType = true;
                        $counter++;
                    }
                }

                $return = trim($return);
            }


            return $return;
        }

        /**
         * AfterSave
         *
         * @param bool  $insert
         * @param array $changedAttributes
         */
        public function afterSave($insert, $changedAttributes) {
            parent::afterSave($insert, $changedAttributes);
            $this->removeOldestLogs();
        }

        /**
         * Remove oldest logs (before first day of last month)
         */
        private function removeOldestLogs() {
            if ((int)date('d') == 10) {
                self::deleteAll(['<', 'started_at', date('Y-m-01', strtotime('-1 month'))]);
            }
        }
    }
