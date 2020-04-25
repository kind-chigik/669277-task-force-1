<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "photos_work".
 *
 * @property int $id
 * @property string $image_path
 * @property int $user_id
 *
 * @property Users $user
 */
class PhotosWork extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photos_work';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_path', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['image_path'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_path' => 'Image Path',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return PhotosWorkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PhotosWorkQuery(get_called_class());
    }
}
