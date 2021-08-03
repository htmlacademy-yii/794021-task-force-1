<?php
namespace R794021\Actions;

use R794021\Tasks\Task;
use R794021\Users\User;


class Apply extends AbstractAction
{
    static protected $name = 'Откликнуться';
    static protected $internalCodename = 'apply';


    public function isValid(User $user, Task $task): bool
    {
        if ($task->getStatus() !== Task::STATUS_NEW) {
            return false;
        }
        return $user->isContractor();
    }
}
