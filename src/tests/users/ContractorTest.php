<?php
use R794021\Users\Contractor;

$contractor = new Contractor(CONTRACTOR_1);
assert($contractor->isContractor());
assert(! $contractor->isCustomer());
