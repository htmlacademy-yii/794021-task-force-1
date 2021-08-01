<?php
namespace R794021\Users;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$contractor = new Contractor(['id' => 24]);
assert($contractor->isContractor());
assert(! $contractor->isCustomer());
