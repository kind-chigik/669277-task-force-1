<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[PhotosWork]].
 *
 * @see PhotosWork
 */
class PhotosWorkQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PhotosWork[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PhotosWork|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
