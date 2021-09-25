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
        $contractors = (new Query())->select('contractor_id')->from('contractor_occupation')->groupBy('contractor_id')->column();

        $users = User::find()
        ->with('contractorOccupations')
        ->with('tasks.review')
        ->select([
            '`user`.`id`',
            '`user`.`fullname`',
            '`user`.`description`',
            '`user`.`avatar_file`',
            '`user`.`website_last_action_datetime`',
            'COUNT(`task`.`contractor_id`) AS `doneTaskCount`',
            'COUNT(`review`.`task_id`) AS `reviewCount`',
            'AVG(`review`.`rating`) AS `rating`'
        ])
        ->leftJoin('task', 'task.contractor_id = user.id')
        ->leftJoin('review', 'task.id = review.task_id')

        ->andWhere(['task.state_id' => Task::STATE_DONE])
        ->andWhere(['user.id' => $contractors])
        ->andWhere(['user.hide_profile' => false])
        ->groupBy('id')
        ->orderBy('user.datetime_created ASC')
        ->all()
        ;
        return $this->render('index', ['items' => $users]);
    }
}
