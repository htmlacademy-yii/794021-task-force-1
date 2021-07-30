<?php
namespace R794021\Actions;

use \R794021\Tasks;
use \R794021\Users;


class Cancel extends AbstractAction
{
    public function __construct()
    {
        $this->name = 'Отмена';
        $this->internalCodename = 'cancel';
    }

    public function isValid(AbstractUser $user, Task $task)
    {
        $customerId = $task->getCustomer()->getId();
        if ( $customerId !== $user->getId() ) {
            return false;
        }

        return ! $task->isInProgress();
    }
}
