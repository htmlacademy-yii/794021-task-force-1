<?php
namespace R794021\Actions;

use R794021\Tasks;
use R794021\Users;


class Reject extends AbstractAction
{
    static protected $name = 'Отказаться';
    static protected $internalCodename = 'reject';

    public function isValid(Users\User $user, Tasks\Task $task)
    {
        if ( ! $task->isRunning() ) {
            return false;
        }

        if ( $task->getContractor() !== $user ) {
            return false;
        }

        return $user->isContractor();
    }
}
