<?php

namespace frontend\controllers;
use yii\web\Controller;
use \yii\db\ActiveQuery;
use \yii\db\Query;
use frontend\models\Contractor;
use frontend\models\ContractorOccupation;
use frontend\models\User;
use frontend\models\Task;

class UsersController extends Controller
{
    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'items' => User::getAvailableContractors(),
            ]
        );
    }
}
