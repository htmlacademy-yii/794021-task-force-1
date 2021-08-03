<?php
use R794021\Users\Contractor;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$contractor = new Contractor(CONTRACTOR_1);
assert($contractor->isContractor());
assert(! $contractor->isCustomer());
