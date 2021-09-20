<?php

namespace frontend\controllers;
use yii\web\Controller;
use \yii\db\ActiveQuery;
use frontend\models\User;

class UsersController extends Controller
{
    public function actionIndex()
    {
        // TODO: show count of the tasks being made
        // TODO: show reviews count
        // TODO: show rating
        // TODO: show stars, based on rating
        // TODO: define proper sorting: by user registration, or last activity
        $users = User::find()
            ->joinWith([
                'contractorOccupations' => function (ActiveQuery $query) {
                    $query->where('contractor_id');
                }])
            ->orderBy('datetime_created', 'desc')
            ->all();
        return $this->render('index', ['items' => $users]);
    }
}
