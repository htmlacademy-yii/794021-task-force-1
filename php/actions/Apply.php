<?php
namespace R794021\Actions;

use R794021\Tasks;
use R794021\Users;


class Apply extends AbstractAction
{
    static protected $name = 'Откликнуться';
    static protected $internalCodename = 'bid';


    public function isValid($user, Tasks\Task $task)
    {
        if ($task->isRunning()) {
            return false;
        }

        return $user->isContractor();
    }
}
