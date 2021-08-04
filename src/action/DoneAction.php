<?php
namespace R794021\Action;

use R794021\Task\Task;
use R794021\Users\User;


class DoneAction extends AbstractAction implements Action
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
