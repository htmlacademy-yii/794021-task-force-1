<?php

use R794021\Tasks;
use R794021\Users;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$customer = new Users\Customer(['id' => 12]);
$contractor = new Users\Contractor(['id' => 24]);
$task = new Tasks\Task(Tasks\Task::STATUS_NEW, $customer);

assert($task->getStatus() === Tasks\Task::STATUS_NEW);
assert($task->getNextStatus(Tasks\Task::ACTION_CANCEL) === Tasks\Task::STATUS_CANCELLED);
assert($task->getNextStatus(Tasks\Task::ACTION_APPLY) === Tasks\Task::STATUS_RUNNING);


// Testing of 'CANCELLED' status
$task = new Tasks\Task(Tasks\Task::STATUS_NEW, $customer, $contractor);
$task->dispatch(Tasks\Task::ACTION_CANCEL);
assert($task->getStatus() === Tasks\Task::STATUS_CANCELLED);


// Testing of 'RUNNING' status
$task = new Tasks\Task(Tasks\Task::STATUS_NEW, $customer, $contractor);
$task->dispatch(Tasks\Task::ACTION_APPLY);
assert($task->getStatus() === Tasks\Task::STATUS_RUNNING);
assert($task->getNextStatus(Tasks\Task::ACTION_CONFIRM_DONE) === Tasks\Task::STATUS_DONE);
assert($task->getNextStatus(Tasks\Task::ACTION_REJECT) === Tasks\Task::STATUS_FAILED);


// Testing of 'DONE' status
$task = new Tasks\Task(Tasks\Task::STATUS_NEW, $customer, $contractor);
$task->dispatch(Tasks\Task::ACTION_APPLY);
$task->dispatch(Tasks\Task::ACTION_CONFIRM_DONE);
assert($task->getStatus() === Tasks\Task::STATUS_DONE);


// Testing of 'FAILED' status
$task = new Tasks\Task(Tasks\Task::STATUS_NEW, $customer, $contractor);
$task->dispatch(Tasks\Task::ACTION_APPLY);
$task->dispatch(Tasks\Task::ACTION_REJECT);
assert($task->getStatus() === Tasks\Task::STATUS_FAILED);
