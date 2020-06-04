<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\db\Query;
use frontend\models\Tasks;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $newTasks = Tasks::find()
        ->isNewTasks()
        ->withCity()
        ->withCategory()
        ->sortByCreationDate(SORT_DESC)
        ->all();

        return $this->render('index.php', [
            'newTasks' => $newTasks
        ]);
    }
}
