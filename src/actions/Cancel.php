<?php
namespace R794021\Actions;

use R794021\Tasks\Task;
use R794021\Users\User;


class Cancel extends AbstractAction
{
    static protected $name = 'Отменить';
    static protected $internalCodename = 'cancel';

    public function isValid(User $user, Task $task): bool
    {
        return
            $task->getCustomer() === $user &&
            $task->getStatus() === Task::STATUS_NEW;
    }
}
