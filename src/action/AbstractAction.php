<?php
namespace R794021\Action;

use R794021\Task\Task;
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
