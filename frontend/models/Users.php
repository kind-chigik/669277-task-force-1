<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $password
 * @property string|null $avatar_path
 * @property string|null $birthday
 * @property string|null $about
 * @property string|null $phone
 * @property string $email
 * @property string|null $skype
 * @property string|null $another_contact
 * @property string|null $registration_date
 * @property string|null $last_visit
 * @property int|null $rank
 * @property string|null $address
 * @property int $city_id
 *
 * @property Attachments[] $attachments
 * @property Categories[] $categories
 * @property Cities $city
 * @property Messages[] $messages
 * @property PhotosWork[] $photosWorks
 * @property Replies[] $replies
 * @property Reviews[] $reviews
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property UserCategories[] $userCategories
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'password', 'email', 'city_id'], 'required'],
            [['birthday', 'registration_date', 'last_visit'], 'safe'],
            [['about'], 'string'],
            [['rank', 'city_id'], 'integer'],
            [['name', 'password', 'phone', 'email', 'skype', 'another_contact'], 'string', 'max' => 64],
            [['avatar_path', 'address'], 'string', 'max' => 128],
            [['email'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
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
            'password' => 'Password',
            'avatar_path' => 'Avatar Path',
            'birthday' => 'Birthday',
            'about' => 'About',
            'phone' => 'Phone',
            'email' => 'Email',
            'skype' => 'Skype',
            'another_contact' => 'Another Contact',
            'registration_date' => 'Registration Date',
            'last_visit' => 'Last Visit',
            'rank' => 'Rank',
            'address' => 'Address',
            'city_id' => 'City ID',
        ];
    }

    /**
     * Gets query for [[Attachments]].
     *
     * @return \yii\db\ActiveQuery|AttachmentsQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachments::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery|CategoriesQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['id' => 'category_id'])->viaTable('user_categories', ['user_id' => 'id']);
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
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery|MessagesQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[PhotosWorks]].
     *
     * @return \yii\db\ActiveQuery|PhotosWorkQuery
     */
    public function getPhotosWorks()
    {
        return $this->hasMany(PhotosWork::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery|RepliesQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Replies::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|ReviewsQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['creator_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery|UserCategoriesQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategories::className(), ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
}
