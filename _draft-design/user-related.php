<?php
/*
 * Draft, pre-design, thoughts of classes
 */

/*
 * User related
 */

abstract class AbstractUser
{
    protected $id;
    protected $fullname;

    public function getId()
    {
        return $this->id;
    }

    public function getFullname()
    {
        return $this->fullname;
    }
}

class User extends AbstractUser
{
}

class Customer extends User
{
    public function __construct()
    {
        $this->favorites = [];
        $this->tasks = [];
    }

    public function addFavorite(Contractor $contractor)
    {
        $this->favorites[] = $contractor;
    }

    public function createTask()
    {
    }

    public function chooseContractor(Task $task, Contractor $contractor)
    {
    }
}

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
