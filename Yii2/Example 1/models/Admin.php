<?php

    namespace app\models;

    use app\components\Base\Core\Model;
    use yii\db\ActiveQuery;

    /**
     * This is the model class for table "admin".
     *
     * @property int  $id
     * @property int  $user_id
     * @property User $user
     */
    class Admin extends Model
    {
        /**
         * {@inheritdoc}
         */
        public static function tableName() {
            return 'admin';
        }

        /**
         * {@inheritdoc}
         */
        public function rules() {
            return [
                [['user_id'], 'required'],
                [['user_id'], 'integer'],
                [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ];
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels() {
            return [
                'id'      => 'ID',
                'user_id' => 'User ID',
            ];
        }

        /**
         * Gets query for [[User]].
         *
         * @return ActiveQuery
         */
        public function getUser() {
            return $this->hasOne(User::className(), ['id' => 'user_id']);
        }
    }
