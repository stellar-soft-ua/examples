<?php

    namespace app\components;

    use Detection\MobileDetect as MobileDetectParent;
    use yii\base\Component;

    class MobileDetect extends Component
    {

        /**
         * @var MobileDetectParent
         */
        private $_mobileDetect;

        /**
         * @param string $name
         * @param array  $parameters
         *
         * @return mixed
         */
        public function __call($name, $parameters) {
            return call_user_func_array(
                [$this->_mobileDetect, $name],
                $parameters
            );
        }

        public function init() {
            $this->_mobileDetect = new MobileDetectParent();
            parent::init();
        }

    }