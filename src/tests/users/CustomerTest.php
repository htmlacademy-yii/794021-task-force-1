<?php
use R794021\Users\Customer;

$customer = new Customer(CUSTOMER_1);
assert($customer->isCustomer());
assert(! $customer->isContractor());
