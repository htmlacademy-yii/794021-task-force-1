<?php
namespace R794021\Actions;

use R794021\Tasks\Task;
use R794021\Users\User;


class Reject extends AbstractAction
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
