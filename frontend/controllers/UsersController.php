<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\db\Query;
use frontend\models\Users;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $executors = Users::find()
        ->isExecutor()
        ->withTasks()
        ->withReviews()
        ->withCategories()
        ->sortByRegistrationDate(SORT_DESC)
        ->all();
        
        return $this->render('index.php', [
            'executors' => $executors
        ]);
    }
}

