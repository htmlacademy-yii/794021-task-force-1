<?php

namespace R794021;

class Contractor extends User
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

    public function rejectTask(Task $task)
    {
    }
}
