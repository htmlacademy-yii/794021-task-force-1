<?php
use R794021\User\{Customer, User};

$customer = new Customer(CUSTOMER_1);
assert($customer instanceof User);
assert($customer->isCustomer());
assert(! $customer->isContractor());
