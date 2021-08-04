<?php
namespace R794021\Action;

use R794021\Tasks\Task;
use R794021\Users\User;


class CancelAction extends AbstractAction implements Action
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
