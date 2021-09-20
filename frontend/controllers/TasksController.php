<?php

namespace frontend\controllers;
use yii\web\Controller;
use frontend\models\Task;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()
            ->with(['category'])
            ->where(['state_id' => Task::STATE_NEW])
            ->orderBy('datetime_created', 'desc')
            ->all();
        return $this->render('index', ['items' => $tasks]);
    }
}
