<?php
namespace R794021\Actions;

use R794021\Tasks;
use R794021\Users;


class Apply extends AbstractAction
{
    static protected $name = 'Откликнуться';
    static protected $internalCodename = 'bid';


    public function isValid(Users\User $user, Tasks\Task $task): bool
    {
        if ($task->getStatus() !== Tasks\Task::STATUS_NEW) {
            return false;
        }

        return $user->isContractor();
    }
}
