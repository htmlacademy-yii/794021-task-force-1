<?php
namespace R794021\Actions;

use R794021\Tasks\Task;
use R794021\Users\User;


abstract class AbstractAction
{
    static protected $name;
    static protected $internalCodename;


    public function getName(): string
    {
        return static::$name;
    }

    public static function getInternalCodename(): string
    {
        return static::$internalCodename;
    }

    abstract public function isValid(User $user, Task $task): bool;
}
