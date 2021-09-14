<?php
namespace Test\User\ContractorTest;

use R794021\User\{Contractor, User};

const CONTRACTOR_1 = ['id' => 24];

$contractor = new Contractor(CONTRACTOR_1);
assert($contractor instanceof User);
assert($contractor->isContractor());
assert(!$contractor->isCustomer());
