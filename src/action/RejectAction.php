<?php
namespace R794021\Action;

use R794021\Task\Task;
use R794021\User\User;


class RejectAction extends AbstractAction implements Action
{
    static protected $name = 'Отказаться';
    static protected $internalCodename = 'reject';

    public function isValid(User $user, Task $task): bool
    {
        return
            $task->getContractor() === $user &&
            $task->isRunning();
    }
}
