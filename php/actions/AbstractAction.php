<?php
namespace R794021\Actions;

use R794021\Tasks;
use R794021\Users;


abstract class AbstractAction
{
    static protected $name;
    static protected $internalCodename;


    public function getName()
    {
        return static::$name;
    }

    public function getInternalCodename()
    {
        return static::$internalCodename;
    }

    abstract public function isValid($user, Tasks\Task $task);
}

