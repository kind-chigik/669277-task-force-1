<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\db\Query;
use frontend\models\Users;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $queryExecutors = new Query();

        $queryExecutors->select(['id', 'name', 'about', 'last_visit', 'rank'])->from('users')->where(['role' => 'executor'])->orderBy(['registration_date' => SORT_DESC]);
        $executors = $queryExecutors->all();

        $queryExecutorsCategories = new Query();
        $queryExecutorsCategories->select(['u.id', 'c.name as category_name'])->from('users u')
        ->join('INNER JOIN', 'user_categories uc', 'user_id = u.id')
        ->join('INNER JOIN', 'categories c', 'category_id = c.id')
        ->where(['role' => 'executor'])->orderBy(['registration_date' => SORT_DESC]);
        $executorsCategories = $queryExecutorsCategories->all();

        $executorsAndTasks = Users::find()->where(['role' => 'executor'])
        ->joinWith('tasks0')
        ->all();
        $executorsAndReviews = Users::find()->where(['role' => 'executor'])
        ->joinWith('reviews')
        ->all();

        $executorsTasks = [];
        foreach ($executorsAndTasks as $tasks) {
            $executorsTasks[] = [
                'user_id' => $tasks['id'],
                'tasks' => count($tasks['tasks0'])
            ];
        }
        $executorsReviews = [];
        foreach ($executorsAndReviews as $reviews) {
            $executorsReviews[] = [
                'user_id' => $reviews['id'],
                'reviews' => count($reviews['reviews'])
            ];
        }
        $tasksCount;
        $reviewsCount;
        $executorsAndCategories = [];
        foreach ($executors as $executor) {
            $categories = [];
            foreach ($executorsCategories as $item) {
                if ($executor['id'] === $item['id']) {
                    $categories[] = $item['category_name'];
                }
            }
            foreach($executorsTasks as $tasks) {
                if ($tasks['user_id'] == $executor['id']) {
                $tasksCount = $tasks['tasks'];
                }
            }
            foreach($executorsReviews as $reviews) {
                if ($reviews['user_id'] == $executor['id']) {
                    $reviewsCount = $reviews['reviews'];
                }
            }
            $executorsAndCategories[] = [
                'id' => $executor['id'],
                'name' => $executor['name'],
                'about' => $executor['about'],
                'last_visit' => $executor['last_visit'],
                'rank' => $executor['rank'],
                'categories_names' => $categories,
                'tasksCount' => $tasksCount,
                'reviewsCount' => $reviewsCount
            ];
        }
        
        return $this->render('index.php', [
            'executorsAndCategories' => $executorsAndCategories,
        ]);
    }
}

