<?php

namespace R794021\Users;


abstract class AbstractUser
{
    protected $id;

    public function __construct($info)
    {
        if ( ! isset($info) && array_key_exists('id', $info) ) {
            throw new \Error('User id is absent');
        }
        $this->id = $info['id'];
    }

    public function getId()
    {
        return $this->id;
    }

    abstract static function isContractor();

    abstract static function isCustomer();
}
