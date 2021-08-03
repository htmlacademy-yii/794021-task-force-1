<?php
use R794021\Users\Customer;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$customer = new Customer(CUSTOMER_1);
assert($customer->isCustomer());
assert(! $customer->isContractor());
