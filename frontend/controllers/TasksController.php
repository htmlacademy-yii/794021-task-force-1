<?php

namespace frontend\controllers;
use yii\web\Controller;
use frontend\models\Task;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $customerId = 3; // TODO: Take customer id from real data
        // TODO: check whether user is customer
        // TODO: add descending sorting (from old to new tasks)
        $tasks = Task::find()
            ->with(['category'])
            ->where(['customer_id' => $customerId, 'state_id' => Task::STATE_NEW])
            ->all();
        return $this->render('index', ['items' => $tasks]);
    }
}
