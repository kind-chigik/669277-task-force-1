<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\db\Query;
use frontend\models\Tasks;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $query = new Query();
        $query->select(['t.id', 't.name', 't.description', 'c.name as category_name', 'cities.city as city_name', 't.budget', 't.creation_date'])->from('tasks t')->join('INNER JOIN', 'categories c', 'category_id = c.id')->join('INNER JOIN', 'cities', 'city_id = cities.id')->where(['status' => 'new'])->orderBy(['creation_date' => SORT_DESC]);
        $dataNewTasks = $query->all();
        return $this->render('index.php', [
            'dataNewTasks' => $dataNewTasks
        ]);
    }
}
