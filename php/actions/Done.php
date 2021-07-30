<?php
namespace R794021\Actions;

use \R794021\Tasks;
use \R794021\Users;


class Done extends AbstractAction
{
    public function __construct()
    {
        $this->name = 'Выполнено';
        $this->internalCodename = 'done';
    }

    public function isValid(AbstractUser $user, Task $task)
    {
        if ( ! $task->isInProgress()) {
            return false;
        }

        $customerId = $task->getCustomer()->getId();
        return $user->getId() === $customerId;
    }
}
