<?php

namespace R794021\User;


class Contractor extends AbstractUser implements User
{
    static public function isContractor(): bool
    {
        return true;
    }

    static public function isCustomer(): bool
    {
        return false;
    }
}
