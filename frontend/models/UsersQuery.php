<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Users]].
 *
 * @see Users
 */
class UsersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Users[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Users|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function isExecutor()
    {
        return $this->andWhere(['role' => 'executor']);
    }

  public function withTasks()
    {
        return $this->joinWith('tasks0');
    }

    public function withReviews()
    {
        return $this->joinWith('reviews');
    }

    public function withCategories()
    {
        return $this->joinWith('categories');
    }

    public function sortByRegistrationDate($sort)
    {
        return $this->orderBy(['registration_date' => $sort]);
    }
}
