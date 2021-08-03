<?php

use R794021\Actions;
use R794021\Tasks;
use R794021\Users;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$done = new Actions\Done();
$customer1 = new Users\Customer(CUSTOMER_1);
$customer2 = new Users\Customer(CUSTOMER_2);
$contractor1 = new Users\Contractor(CONTRACTOR_1);
$contractor2 = new Users\Contractor(CONTRACTOR_2);

/*
    Checking the name of the Action
 */
assert($done->getName() === 'Выполнено');
assert($done->getName() !== ' Выполнено');

/*
    Checking the internal codename of the Action
 */
assert($done->getInternalCodename() === 'done');
assert($done->getInternalCodename() !== ' done');

/*
    Conditions:
        The task in the New status

    Expected:
        No one may confirm the task is done
*/
$task1 = new Tasks\Task(Tasks\Task::STATUS_NEW, $customer1);
assert(! $done->isValid($customer1, $task1));
assert(! $done->isValid($customer2, $task1));
assert(! $done->isValid($contractor1, $task1));
assert(! $done->isValid($contractor2, $task1));

/*
    Conditions:
        The task in the Running status

    Expected:
        Only its customer may confirm the task is done
*/
$task1 = new Tasks\Task(Tasks\Task::STATUS_RUNNING, $customer1, $contractor1);
assert($done->isValid($customer1, $task1));
assert(! $done->isValid($customer2, $task1));
assert(! $done->isValid($contractor1, $task1));
assert(! $done->isValid($contractor2, $task1));

/*
    Conditions:
        The task in the Failed status

    Expected:
        Only its customer may confirm the task is done
*/
$task1 = new Tasks\Task(Tasks\Task::STATUS_FAILED, $customer1, $contractor1);
assert(! $done->isValid($customer1, $task1));
assert(! $done->isValid($customer2, $task1));
assert(! $done->isValid($contractor1, $task1));
assert(! $done->isValid($contractor2, $task1));

/*
    Conditions:
        The task in the Done status

    Expected:
        No one may re-confirm the task is done
*/
$task1 = new Tasks\Task(Tasks\Task::STATUS_DONE, $customer1, $contractor1);
assert(! $done->isValid($customer1, $task1));
assert(! $done->isValid($customer2, $task1));
assert(! $done->isValid($contractor1, $task1));
assert(! $done->isValid($contractor2, $task1));
