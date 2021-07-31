<?php

namespace R794021\Users;


class Customer extends AbstractUser
{
    public function __construct($info)
    {
        parent::__construct($info);
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

    static public function isContractor()
    {
        return false;
    }

    static public function isCustomer()
    {
        return true;
    }
}
