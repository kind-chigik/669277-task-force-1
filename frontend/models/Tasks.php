<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int|null $budget
 * @property string|null $creation_date
 * @property string|null $expire
 * @property string|null $status
 * @property int $category_id
 * @property string|null $address
 * @property int|null $city_id
 * @property int|null $creator_id
 * @property int|null $executor_id
 * @property int $latitude
 * @property int $longitude
 *
 * @property Attachments[] $attachments
 * @property Categories $category
 * @property Cities $city
 * @property Users $creator
 * @property Users $executor
 * @property Messages[] $messages
 * @property Replies[] $replies
 * @property Reviews[] $reviews
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'category_id', 'latitude', 'longitude'], 'required'],
            [['description', 'status'], 'string'],
            [['budget', 'category_id', 'city_id', 'creator_id', 'executor_id', 'latitude', 'longitude'], 'integer'],
            [['creation_date', 'expire'], 'safe'],
            [['name', 'address'], 'string', 'max' => 128],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['creator_id' => 'id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['executor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'budget' => 'Budget',
            'creation_date' => 'Creation Date',
            'expire' => 'Expire',
            'status' => 'Status',
            'category_id' => 'Category ID',
            'address' => 'Address',
            'city_id' => 'City ID',
            'creator_id' => 'Creator ID',
            'executor_id' => 'Executor ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    /**
     * Gets query for [[Attachments]].
     *
     * @return \yii\db\ActiveQuery|AttachmentsQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachments::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|CategoriesQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|CitiesQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Creator]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getCreator()
    {
        return $this->hasOne(Users::className(), ['id' => 'creator_id']);
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(Users::className(), ['id' => 'executor_id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery|MessagesQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery|RepliesQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Replies::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|ReviewsQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['task_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TasksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TasksQuery(get_called_class());
    }
}
