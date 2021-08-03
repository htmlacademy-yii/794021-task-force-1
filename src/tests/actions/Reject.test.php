<?php

use R794021\Actions;
use R794021\Tasks;
use R794021\Users;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$reject = new Actions\Reject();
$customer1 = new Users\Customer(CUSTOMER_1);
$customer2 = new Users\Customer(CUSTOMER_2);
$contractor1 = new Users\Contractor(CONTRACTOR_1);
$contractor2 = new Users\Contractor(CONTRACTOR_2);

/*
    Checking the name of the Action
 */
assert($reject->getName() === 'Отказаться');
assert($reject->getName() !== ' Отказаться');

/*
    Checking the internal codename of the Action
 */
assert($reject->getInternalCodename() === 'reject');
assert($reject->getInternalCodename() !== ' reject');

/*
    Conditions:
        The task in the New status

    Expected:
        No one may reject unstarted task
*/
$task1 = new Tasks\Task(Tasks\Task::STATUS_NEW, $customer1);
assert(! $reject->isValid($customer1, $task1));
assert(! $reject->isValid($customer2, $task1));
assert(! $reject->isValid($contractor1, $task1));
assert(! $reject->isValid($contractor2, $task1));

/*
    Conditions:
        The task in the Running status

    Expected:
        Only its contractor may reject the running task
*/
$task1 = new Tasks\Task(Tasks\Task::STATUS_RUNNING, $customer1, $contractor1);
assert($reject->isValid($contractor1, $task1));
assert(! $reject->isValid($contractor2, $task1));
assert(! $reject->isValid($customer1, $task1));
assert(! $reject->isValid($customer2, $task1));

/*
    Conditions:
        The task in the Done status

    Expected:
        No one may reject the finished task
*/
$task1 = new Tasks\Task(Tasks\Task::STATUS_DONE, $customer1);
assert(! $reject->isValid($contractor1, $task1));
assert(! $reject->isValid($contractor2, $task1));
assert(! $reject->isValid($customer1, $task1));
assert(! $reject->isValid($customer2, $task1));

/*
    Conditions:
        The task in the Done status

    Expected:
        No one may reject the Failed task
*/
$task1 = new Tasks\Task(Tasks\Task::STATUS_FAILED, $customer1);
assert(! $reject->isValid($contractor1, $task1));
assert(! $reject->isValid($contractor2, $task1));
assert(! $reject->isValid($customer1, $task1));
assert(! $reject->isValid($customer2, $task1));
