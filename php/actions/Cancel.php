<?php
namespace R794021\Actions;

use R794021\Tasks;
use R794021\Users;


class Cancel extends AbstractAction
{
    static protected $name = 'Отменить';
    static protected $internalCodename = 'cancel';

    public function isValid($user, Tasks\Task $task)
    {
        $userId = $user->getId();
        $customerId = $task->getCustomer()->getId();
        if ( $customerId !== $userId ) {
            return false;
        }

        return $task->getStatus() === Tasks\Task::STATUS_NEW;
    }
}
