<?php

use R794021\Tasks\Task;
use R794021\Users\Contractor;
use R794021\Users\Customer;

$customer = new Customer(CUSTOMER_1);
$contractor = new Contractor(CONTRACTOR_1);

// Testing of 'NEW' status
$task = new Task(Task::STATUS_NEW, $customer);
assert($task->getStatus() === Task::STATUS_NEW);
assert($task->getNextStatus(Task::ACTION_CANCEL) === Task::STATUS_CANCELLED);
assert($task->getNextStatus(Task::ACTION_APPLY) === Task::STATUS_RUNNING);
assert(! $task->isRunning());
assert($task->getCustomer() == $customer);
assert(! $task->getContractor());

// Testing of 'CANCELLED' status
$task = new Task(Task::STATUS_CANCELLED, $customer, $contractor);
assert($task->getStatus() === Task::STATUS_CANCELLED);
assert(! $task->isRunning());
assert($task->getCustomer() == $customer);
assert($task->getContractor() == $contractor);
assert($task->getCustomer() !== $task->getContractor());

// Testing of 'RUNNING' status
$task = new Task(Task::STATUS_RUNNING, $customer, $contractor);
assert($task->getStatus() === Task::STATUS_RUNNING);
assert($task->isRunning());
assert($task->getNextStatus(Task::ACTION_CONFIRM_DONE) === Task::STATUS_DONE);
assert($task->getNextStatus(Task::ACTION_REJECT) === Task::STATUS_FAILED);
assert($task->getCustomer() == $customer);
assert($task->getContractor() == $contractor);
assert($task->getCustomer() !== $task->getContractor());

// Testing of 'DONE' status
$task = new Task(Task::STATUS_DONE, $customer, $contractor);
assert($task->getStatus() === Task::STATUS_DONE);
assert(! $task->isRunning());
assert($task->getCustomer() == $customer);
assert($task->getContractor() == $contractor);
assert($task->getCustomer() !== $task->getContractor());

// Testing of 'FAILED' status
$task = new Task(Task::STATUS_FAILED, $customer, $contractor);
assert($task->getStatus() === Task::STATUS_FAILED);
assert(! $task->isRunning());
assert($task->getCustomer() == $customer);
assert($task->getContractor() == $contractor);
assert($task->getCustomer() !== $task->getContractor());


