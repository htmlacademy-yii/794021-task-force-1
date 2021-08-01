<?php

namespace R794021\Users;


abstract class AbstractUser
{
    protected $id;
    protected $fullname;

    public function __construct($info)
    {
        if ( ! isset($info) && array_key_exists('id', $info) ) {
            throw new \Error('Insufficient user information');
        }
        $this->id = $info['id'];
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
