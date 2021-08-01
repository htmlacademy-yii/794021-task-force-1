<?php
namespace R794021\Actions;

use R794021\Tasks;
use R794021\Users;


class Done extends AbstractAction
{
    static protected $name = 'Выполнено';
    static protected $internalCodename = 'done';

    public function isValid(Users\User $user, Tasks\Task $task)
    {
        if ( ! $task->isRunning() ) {
            return false;
        }

        $customerId = $task->getCustomer()->getId();
        return $user->getId() === $customerId;
    }
}
