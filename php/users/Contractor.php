<?php

namespace R794021\Users;


class Contractor extends AbstractUser
{
    public function __construct()
    {
        $this->tasks = [];
    }

    public function bidTask(Task $task)
    {
        $this->tasks[] = $task;
    }

    public function getBid(Task $task)
    {
        return $task->getBid($this);
    }

    public function isContractor()
    {
        return true;
    }

    public function isCustomer()
    {
        return false;
    }

    public function rejectTask(Task $task)
    {
    }
}
