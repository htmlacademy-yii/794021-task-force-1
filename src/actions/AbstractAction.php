<?php
namespace R794021\Actions;

use R794021\Tasks;
use R794021\Users;


abstract class AbstractAction
{
    static protected $name;
    static protected $internalCodename;


    public function getName(): string
    {
        return static::$name;
    }

    public function getInternalCodename(): string
    {
        return static::$internalCodename;
    }

    abstract public function isValid(Users\User $user, Tasks\Task $task): bool;
}
