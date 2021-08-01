<?php

namespace R794021\Users;


class Contractor extends AbstractUser implements User
{
    static public function isContractor()
    {
        return true;
    }

    static public function isCustomer()
    {
        return false;
    }
}
