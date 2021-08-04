<?php

use R794021\Task\Task;
use R794021\User\{Contractor, Customer};
use R794021\Action\{ApplyAction, CancelAction, DoneAction, RejectAction};


$customer = new Customer(CUSTOMER_1);
$contractor = new Contractor(CONTRACTOR_1);

// Testing of 'NEW' status
$task = new Task(Task::STATUS_NEW, $customer);
assert($task->getStatus() === Task::STATUS_NEW);
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

// Testing of 'getNextStatus' status
assert($task->getNextStatus(new ApplyAction()) === Task::STATUS_RUNNING);
assert($task->getNextStatus(new CancelAction()) === Task::STATUS_CANCELLED);
assert($task->getNextStatus(new DoneAction()) === Task::STATUS_DONE);
assert($task->getNextStatus(new RejectAction()) === Task::STATUS_FAILED);
