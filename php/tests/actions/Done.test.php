<?php

use R794021\Actions;
use R794021\Tasks;
use R794021\Users;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$action = new Actions\Done();

assert($action->getName() === 'Выполнено');
assert($action->getName() !== ' Выполнено');

assert($action->getInternalCodename() === 'done');
assert($action->getInternalCodename() !== ' done');

$customer1 = new Users\Customer(['id' => 12]);
$customer2 = new Users\Customer(['id' => 13]);
$contractor1 = new Users\Contractor(['id' => 24]);
$contractor2 = new Users\Contractor(['id' => 26]);
$task1 = new Tasks\Task(Tasks\Task::STATUS_NEW, $customer1);

assert(! $action->isValid($customer1, $task1));
assert(! $action->isValid($customer2, $task1));
assert(! $action->isValid($contractor1, $task1));

$task1->dispatch(Tasks\Task::ACTION_APPLY);

assert($action->isValid($customer1, $task1));
assert(! $action->isValid($customer2, $task1));
assert(! $action->isValid($contractor1, $task1));

$task1->dispatch(Tasks\Task::ACTION_REJECT);

assert(! $action->isValid($customer1, $task1));
assert(! $action->isValid($customer2, $task1));
assert(! $action->isValid($contractor1, $task1));
