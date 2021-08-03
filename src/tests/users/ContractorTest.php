<?php
use R794021\Users\Contractor;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$contractor = new Contractor(['id' => 24]);
assert($contractor->isContractor());
assert(! $contractor->isCustomer());
