<?php
namespace R794021\Actions;

use \R794021\Tasks;
use \R794021\Users;


class Reject extends AbstractAction
{
    public function __construct()
    {
        $this->name = 'Отказаться';
        $this->internalCodename = 'reject';
    }

    public function isValid(AbstractUser $user, Task $task)
    {
        if ( ! $task->isInProgress()) {
            return false;
        }

        return $user->isContractor();
    }
}
