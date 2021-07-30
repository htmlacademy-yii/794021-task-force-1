<?php

namespace R794021;

class Customer extends AbstractUser
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

    public function isContractor()
    {
        return true;
    }

    public function isCustomer()
    {
        return false;
    }

}
