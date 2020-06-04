<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Tasks]].
 *
 * @see Tasks
 */
class TasksQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Tasks[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Tasks|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function isNewTasks()
    {
        return $this->where(['status' => 'new']);
    }

    public function withCity()
    {
        return $this->joinWith('city');
    }

    public function withCategory()
    {
        return $this->joinWith('category');
    }

    public function sortByCreationDate($sort) {
        return $this->orderBy(['creation_date' => $sort]);
    }
}
