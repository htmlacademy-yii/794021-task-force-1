<?php

use R794021\Actions;
use R794021\Tasks;
use R794021\Users;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$action = new Actions\Cancel();

assert($action->getName() === 'Отменить');
assert($action->getName() !== ' Отменить');

assert($action->getInternalCodename() === 'cancel');
assert($action->getInternalCodename() !== 'apply');

$customer1 = new Users\Customer(['id' => 12]);
$customer2 = new Users\Customer(['id' => 23]);
$task1 = new Tasks\Task(Tasks\Task::STATUS_NEW, $customer1);

assert($action->isValid($customer1, $task1));

assert(! $action->isValid($customer2, $task1));
