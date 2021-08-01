<?php

namespace R794021\Users;


class Customer extends AbstractUser implements User
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
