<?php

use R794021\Actions;
use R794021\Tasks;
use R794021\Users;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$apply = new Actions\Apply();
$customer1 = new Users\Customer(['id' => 12]);
$contractor = new Users\Contractor(['id' => 24]);
$customer2 = new Users\Customer(['id' => 13]);

/*
    Checking the name of the Action
 */
assert($apply->getName() === 'Откликнуться');
assert($apply->getName() !== ' Откликнуться');

/*
    Checking the internal codename of the Action
 */
assert($apply->getInternalCodename() === 'apply');
assert($apply->getInternalCodename() !== ' apply');

/*
    Conditions:
        The task is in the New status
    Expected:
        Only user with 'Contractor' class can apply
 */
$task = new Tasks\Task(Tasks\Task::STATUS_NEW, $customer1);
assert($apply->isValid($contractor, $task));
assert(! $apply->isValid($customer1, $task));
assert(! $apply->isValid($customer2, $task));

/*
    Conditions:
        The task is in the Running status
    Expected:
        No one can apply for the already running task
 */
$task = new Tasks\Task(Tasks\Task::STATUS_RUNNING, $customer1, $contractor);
assert(! $apply->isValid($contractor, $task));
assert(! $apply->isValid($customer1, $task));
assert(! $apply->isValid($customer2, $task));

/*
    Conditions:
        The task is in the Done status
    Expected:
        No one can apply for the already running task
 */
$task = new Tasks\Task(Tasks\Task::STATUS_DONE, $customer1, $contractor);
assert(! $apply->isValid($contractor, $task));
assert(! $apply->isValid($customer1, $task));
assert(! $apply->isValid($customer2, $task));

/*
    Conditions:
        The task is in the Failed status
    Expected:
        No one can apply for the already running task
 */
$task = new Tasks\Task(Tasks\Task::STATUS_FAILED, $customer1, $contractor);
assert(! $apply->isValid($contractor, $task));
assert(! $apply->isValid($customer1, $task));
assert(! $apply->isValid($customer2, $task));
