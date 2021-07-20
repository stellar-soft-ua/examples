<?php

    namespace app\models;

    use app\components\Base\Core\Model;
    use Yii;
    use yii\db\ActiveQuery;

    /**
     * This is the model class for table "address".
     *
     * @property int           $id
     * @property string        $street
     * @property string|null   $zip_code
     * @property string|null   $state
     * @property string|null   $state_abbreviation
     * @property string|null   $city
     * @property string|null   $latitude
     * @property string|null   $longitude
     * @property string|null   $google_formatted_address
     * @property string|null   $google_place_id
     * @property resource|null $google_response
     * @property Contractor[]  $contractors
     * @property Property[]    $properties
     */
    class Address extends Model
    {
        /**
         * {@inheritdoc}
         */
        public static function tableName() {
            return 'address';
        }

        /**
         * {@inheritdoc}
         */
        public function rules() {
            return [
                ['google_place_id', 'required', 'on' => ['addressRequired']],
                [['google_response'], 'string'],
                [['zip_code', 'state', 'state_abbreviation', 'city', 'google_formatted_address', 'google_place_id', 'street'], 'string', 'max' => 255],
                [['latitude', 'longitude'], 'safe'],
            ];
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels() {
            return [
                'id'                       => Yii::t('model', 'ID'),
                'street'                   => Yii::t('model', 'Address'),
                'zip_code'                 => Yii::t('model', 'Zip Code'),
                'state'                    => Yii::t('model', 'State'),
                'state_abbreviation'       => Yii::t('model', 'State Abbreviation'),
                'city'                     => Yii::t('model', 'City'),
                'latitude'                 => Yii::t('model', 'Latitude'),
                'longitude'                => Yii::t('model', 'Longitude'),
                'google_formatted_address' => Yii::t('model', 'Google Formatted Address'),
                'google_place_id'          => Yii::t('model', 'Address'),
                'google_response'          => Yii::t('model', 'Google Response'),
            ];
        }

        /**
         * Gets query for [[Contractors]].
         *
         * @return ActiveQuery
         */
        public function getContractors() {
            return $this->hasMany(Contractor::className(), ['address_id' => 'id']);
        }

        /**
         * Gets query for [[Properties]].
         *
         * @return ActiveQuery
         */
        public function getProperties() {
            return $this->hasMany(Property::className(), ['address_id' => 'id']);
        }

        /**
         * Returns friendly address format (can be used only with the own address attribute)
         *
         * @param string $delimiter
         * @param string $tagContainerClass
         *
         * @return string|null
         */
        public function getFriendlyFormat($tagContainerClass = 'address-container', $delimiter = ',') {
            $address = $this->google_formatted_address;

            return self::getAddressFriendlyFormat($address, $tagContainerClass, $delimiter);
        }

        /**
         * Returns friendly address format (can be used only with the some specific address)
         *
         * @param        $address
         * @param string $delimiter
         * @param string $tagContainerClass
         *
         * @return string|string[]
         */
        public static function getAddressFriendlyFormat($address, $tagContainerClass = 'address-container', $delimiter = ',') {
            if ($delimiter && $address) {
                $address = '<div class="' . $tagContainerClass . '">
                                <span>' .
                           str_replace($delimiter, '</span><span>', $address) .
                           '</span>
                            </div>';
            }

            return $address;
        }

        /**
         * Returns report address format (can be used only with the own address attribute)
         *
         * @return string|null
         */
        public function getReportFormat() {
            $address = $this->google_formatted_address;

            $address = preg_replace(['/\s+/', '/\.+|\,+/'], ['-', ''], trim(($address)));

            return $address;
        }
    }
