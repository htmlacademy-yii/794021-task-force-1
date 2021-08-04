<?php

use R794021\Action\RejectAction;
use R794021\Task\Task;
use R794021\User\{Contractor, Customer};

$reject = new RejectAction();
$customer1 = new Customer(CUSTOMER_1);
$customer2 = new Customer(CUSTOMER_2);
$contractor1 = new Contractor(CONTRACTOR_1);
$contractor2 = new Contractor(CONTRACTOR_2);

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
$task1 = new Task(Task::STATUS_NEW, $customer1);
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
$task1 = new Task(Task::STATUS_RUNNING, $customer1, $contractor1);
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
$task1 = new Task(Task::STATUS_DONE, $customer1);
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
$task1 = new Task(Task::STATUS_FAILED, $customer1);
assert(! $reject->isValid($contractor1, $task1));
assert(! $reject->isValid($contractor2, $task1));
assert(! $reject->isValid($customer1, $task1));
assert(! $reject->isValid($customer2, $task1));
