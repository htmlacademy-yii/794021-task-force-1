<?php

namespace R794021\User;

use R794021\Exception\DataDomainException;


abstract class AbstractUser
{
    protected $id;

    public function __construct(array $userInfo)
    {
        if ( ! array_key_exists('id', $userInfo) ) {
            throw new DataDomainException('User id field should exist');
        }
        $this->id = $userInfo['id'];
        if ( ! is_int($this->id) || $this->id <= 0 ) {
            throw new DataDomainException('User id should be positive integer');
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    abstract static function isContractor(): bool;

    abstract static function isCustomer(): bool;
}
