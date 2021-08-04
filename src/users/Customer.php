<?php

namespace R794021\Users;


class Customer extends AbstractUser implements User
{
    static public function isContractor(): bool
    {
        return false;
    }

    static public function isCustomer(): bool
    {
        return true;
    }
}
