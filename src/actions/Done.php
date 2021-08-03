<?php
namespace R794021\Actions;

use R794021\Tasks\Task;
use R794021\Users\User;


class Done extends AbstractAction
{
    static protected $name = 'Выполнено';
    static protected $internalCodename = 'done';

    public function isValid(User $user, Task $task): bool
    {
        return
            $task->getCustomer() === $user &&
            $task->isRunning();
    }
}
