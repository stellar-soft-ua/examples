<?php

    namespace app\models;

    use app\components\Base\Core\Model;
    use Yii;
    use yii\db\ActiveQuery;

    /**
     * This is the model class for table "asset".
     *
     * @property int                $id
     * @property string             $title
     * @property string|null        $description
     * @property string|null        $created
     * @property int                $created_by
     * @property string|null        $updated
     * @property int|null           $updated_by
     * @property Category           $category
     * @property User               $createdBy
     * @property User               $updatedBy
     * @property AssetHasFile[]     $assetHasFiles
     * @property AssetHasCategory[] $assetHasCategories
     */
    class Asset extends Model
    {
        /**
         * {@inheritdoc}
         */
        public static function tableName() {
            return 'asset';
        }

        /**
         * {@inheritdoc}
         */
        public function rules() {
            return [
                [['title'], 'required'],
                [['description'], 'string'],
                [['created_by', 'updated_by'], 'integer'],
                [['created', 'updated'], 'safe'],
                [['title'], 'string', 'max' => 255],
                [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
                [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            ];
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels() {
            return [
                'id'          => Yii::t('model', 'ID'),
                'title'       => Yii::t('model', 'Title'),
                'description' => Yii::t('model', 'Description'),
                'created'     => Yii::t('model', 'Created'),
                'created_by'  => Yii::t('model', 'Created By'),
                'updated'     => Yii::t('model', 'Updated'),
                'updated_by'  => Yii::t('model', 'Updated By'),
            ];
        }

        /**
         * Before save event
         *
         * @param bool $insert
         *
         * @return bool
         */
        public function beforeSave($insert) {
            $this->setFile();

            return parent::beforeSave($insert);
        }

        /**
         * After Save Method
         *
         * @param bool  $insert
         * @param array $changedAttributes
         */
        public function afterSave($insert, $changedAttributes) {
            parent::afterSave($insert, $changedAttributes);
            $this->saveFile();
        }

        /**
         * Gets query for [[CreatedBy]].
         *
         * @return ActiveQuery
         */
        public function getCreatedBy() {
            return $this->hasOne(User::className(), ['id' => 'created_by']);
        }

        /**
         * Gets query for [[UpdatedBy]].
         *
         * @return ActiveQuery
         */
        public function getUpdatedBy() {
            return $this->hasOne(User::className(), ['id' => 'updated_by']);
        }

        /**
         * Gets query for [[AssetHasFiles]].
         *
         * @return ActiveQuery
         */
        public function getAssetHasFiles() {
            return $this->hasMany(AssetHasFile::className(), ['asset_id' => 'id']);
        }

        /**
         * Gets query for [[AssetHasFiles]].
         *
         * @return ActiveQuery
         */
        public function getAssetHasCategories() {
            return $this->hasMany(AssetHasCategory::className(), ['asset_id' => 'id']);
        }
    }
