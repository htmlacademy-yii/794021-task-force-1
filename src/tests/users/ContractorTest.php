<?php
use R794021\Users\{Contractor, User};

$contractor = new Contractor(CONTRACTOR_1);
assert($contractor instanceof User);
assert($contractor->isContractor());
assert(! $contractor->isCustomer());
