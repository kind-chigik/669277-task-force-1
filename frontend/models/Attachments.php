<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "attachments".
 *
 * @property int $id
 * @property string $url_file
 * @property int|null $user_id
 * @property int $task_id
 *
 * @property Tasks $task
 * @property Users $user
 */
class Attachments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attachments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url_file', 'task_id'], 'required'],
            [['user_id', 'task_id'], 'integer'],
            [['url_file'], 'string', 'max' => 128],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url_file' => 'Url File',
            'user_id' => 'User ID',
            'task_id' => 'Task ID',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
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
     * @return AttachmentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AttachmentsQuery(get_called_class());
    }
}
