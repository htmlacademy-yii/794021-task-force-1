<?php

namespace frontend\controllers;
use yii\web\Controller;
use frontend\models\Task;

class TasksController extends Controller
{
    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'items' => Task::getTasks()
            ]
        );
    }
}
