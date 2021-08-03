<?php
use R794021\Users\{Customer, User};

$customer = new Customer(CUSTOMER_1);
assert($customer instanceof User);
assert($customer->isCustomer());
assert(! $customer->isContractor());
