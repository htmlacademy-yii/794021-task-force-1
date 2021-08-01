<?php

namespace R794021\Users;


class Customer extends AbstractUser
{
    static public function isContractor()
    {
        return false;
    }

    static public function isCustomer()
    {
        return true;
    }
}
