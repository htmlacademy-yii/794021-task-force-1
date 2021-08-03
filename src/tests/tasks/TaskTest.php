<?php

use R794021\Tasks;
use R794021\Users;

$customer = new Users\Customer(CUSTOMER_1);
$contractor = new Users\Contractor(CONTRACTOR_1);

// Testing of 'NEW' status
$task = new Tasks\Task(Tasks\Task::STATUS_NEW, $customer);
assert($task->getStatus() === Tasks\Task::STATUS_NEW);
assert($task->getNextStatus(Tasks\Task::ACTION_CANCEL) === Tasks\Task::STATUS_CANCELLED);
assert($task->getNextStatus(Tasks\Task::ACTION_APPLY) === Tasks\Task::STATUS_RUNNING);
assert(! $task->isRunning());
assert($task->getCustomer() == $customer);
assert(! $task->getContractor());

// Testing of 'CANCELLED' status
$task = new Tasks\Task(Tasks\Task::STATUS_CANCELLED, $customer, $contractor);
assert($task->getStatus() === Tasks\Task::STATUS_CANCELLED);
assert(! $task->isRunning());
assert($task->getCustomer() == $customer);
assert($task->getContractor() == $contractor);
assert($task->getCustomer() !== $task->getContractor());

// Testing of 'RUNNING' status
$task = new Tasks\Task(Tasks\Task::STATUS_RUNNING, $customer, $contractor);
assert($task->getStatus() === Tasks\Task::STATUS_RUNNING);
assert($task->isRunning());
assert($task->getNextStatus(Tasks\Task::ACTION_CONFIRM_DONE) === Tasks\Task::STATUS_DONE);
assert($task->getNextStatus(Tasks\Task::ACTION_REJECT) === Tasks\Task::STATUS_FAILED);
assert($task->getCustomer() == $customer);
assert($task->getContractor() == $contractor);
assert($task->getCustomer() !== $task->getContractor());

// Testing of 'DONE' status
$task = new Tasks\Task(Tasks\Task::STATUS_DONE, $customer, $contractor);
assert($task->getStatus() === Tasks\Task::STATUS_DONE);
assert(! $task->isRunning());
assert($task->getCustomer() == $customer);
assert($task->getContractor() == $contractor);
assert($task->getCustomer() !== $task->getContractor());

// Testing of 'FAILED' status
$task = new Tasks\Task(Tasks\Task::STATUS_FAILED, $customer, $contractor);
assert($task->getStatus() === Tasks\Task::STATUS_FAILED);
assert(! $task->isRunning());
assert($task->getCustomer() == $customer);
assert($task->getContractor() == $contractor);
assert($task->getCustomer() !== $task->getContractor());


