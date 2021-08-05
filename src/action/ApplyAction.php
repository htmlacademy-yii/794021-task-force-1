<?php
namespace R794021\Action;

use R794021\Task\Task;
use R794021\User\User;


class ApplyAction extends AbstractAction implements Action
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
