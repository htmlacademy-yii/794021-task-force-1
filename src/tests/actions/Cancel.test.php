<?php

use R794021\Actions;
use R794021\Tasks;
use R794021\Users;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$action = new Actions\Cancel();
$customer1 = new Users\Customer(['id' => 12]);
$contractor1 = new Users\Contractor(['id' => 24]);
$customer2 = new Users\Customer(['id' => 13]);
$contractor2 = new Users\Contractor(['id' => 26]);

/*
    Checking the name of the Action
 */
assert($action->getName() === 'Отменить');
assert($action->getName() !== ' Отменить');

/*
    Checking the internal codename of the Action
 */
assert($action->getInternalCodename() === 'cancel');
assert($action->getInternalCodename() !== 'apply');

/*
    Conditions:
        The task in the 'NEW' status

    Expected:
        Only its customer can dispatch 'Cancel' action
*/
$task1 = new Tasks\Task(Tasks\Task::STATUS_NEW, $customer1);
assert($action->isValid($customer1, $task1));
assert(! $action->isValid($customer2, $task1));
assert(! $action->isValid($contractor1, $task1));
assert(! $action->isValid($contractor2, $task1));

/*
    Conditions:
        The task is started

    Expected:
        No user can cancel the task
*/
$task1 = new Tasks\Task(Tasks\Task::STATUS_RUNNING, $customer1, $contractor1);
assert(! $action->isValid($customer1, $task1));
assert(! $action->isValid($customer2, $task1));
assert(! $action->isValid($contractor1, $task1));
assert(! $action->isValid($contractor2, $task1));

/*
    Conditions:
        The task is in the cancelled status

    Expected:
        No one can cancel the task
*/
$task1 = new Tasks\Task(Tasks\Task::STATUS_CANCELLED, $customer1, $contractor1);
assert(! $action->isValid($customer1, $task1));
assert(! $action->isValid($customer2, $task1));
assert(! $action->isValid($contractor1, $task1));
assert(! $action->isValid($contractor2, $task1));

/*
    Conditions:
        The task is done

    Expected:
        No one can cancel the task the second time
*/
$task1 = new Tasks\Task(Tasks\Task::STATUS_DONE, $customer1, $contractor1);
assert(! $action->isValid($customer1, $task1));
assert(! $action->isValid($customer2, $task1));
assert(! $action->isValid($contractor1, $task1));
assert(! $action->isValid($contractor2, $task1));

/*
    Conditions:
        The task is failed

    Expected:
        No one can cancel the task the second time
*/
$task1 = new Tasks\Task(Tasks\Task::STATUS_DONE, $customer1, $contractor1);
assert(! $action->isValid($customer1, $task1));
assert(! $action->isValid($customer2, $task1));
assert(! $action->isValid($contractor1, $task1));
assert(! $action->isValid($contractor2, $task1));
