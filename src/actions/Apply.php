<?php
namespace R794021\Actions;

use R794021\Tasks\Task;
use R794021\Users\User;


class Apply extends AbstractAction implements Action
{
    static protected $name = 'Откликнуться';
    static protected $internalCodename = 'apply';


    public function isValid(User $user, Task $task): bool
    {
        return
            $task->getStatus() === Task::STATUS_NEW &&
            $user->isContractor();
    }
}
