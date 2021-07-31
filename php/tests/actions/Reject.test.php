<?php

use R794021\Actions;
use R794021\Tasks;
use R794021\Users;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$apply = new Actions\Reject();

assert($apply->getName() === 'Отказаться');
assert($apply->getName() !== ' Отказаться');

assert($apply->getInternalCodename() === 'reject');
assert($apply->getInternalCodename() !== ' reject');

$customer = new Users\Customer(['id' => 3]);
$contractor = new Users\Contractor(['id' => 6]);
$task = new Tasks\Task(Tasks\Task::STATUS_NEW, $customer);

assert(! $apply->isValid($contractor, $task));
assert(! $apply->isValid($customer, $task));

$task->dispatch(Tasks\Task::ACTION_APPLY);
assert($apply->isValid($contractor, $task));
assert(! $apply->isValid($customer, $task));
