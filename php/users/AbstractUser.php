<?php

namespace R794021\Users;


abstract class AbstractUser
{
    protected $id;
    protected $fullname;

    public function __construct($info)
    {
        $this->id = $info['id'] ?? NULL;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFullname()
    {
        return $this->fullname;
    }

    static abstract function isContractor();

    static abstract function isCustomer();
}
