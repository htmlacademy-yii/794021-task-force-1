<?php
namespace Test\User\CustomerTest;

use R794021\User\{Customer, User};

const CUSTOMER_1 = ['id' => 12];

$customer = new Customer(CUSTOMER_1);
assert($customer instanceof User);
assert($customer->isCustomer());
assert(!$customer->isContractor());
