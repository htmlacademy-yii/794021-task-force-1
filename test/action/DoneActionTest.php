<?php
namespace Test\Action\DoneActionTest;

use R794021\Action\DoneAction;
use R794021\Task\Task;
use R794021\User\{Contractor, Customer};

const CUSTOMER_1 = ['id' => 12];
const CUSTOMER_2 = ['id' => 13];
const CONTRACTOR_1 = ['id' => 24];
const CONTRACTOR_2 = ['id' => 26];

$done = new DoneAction();
$customer1 = new Customer(CUSTOMER_1);
$customer2 = new Customer(CUSTOMER_2);
$contractor1 = new Contractor(CONTRACTOR_1);
$contractor2 = new Contractor(CONTRACTOR_2);

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
$task1 = new Task(Task::STATUS_NEW, $customer1);
assert(!$done->isValid($customer1, $task1));
assert(!$done->isValid($customer2, $task1));
assert(!$done->isValid($contractor1, $task1));
assert(!$done->isValid($contractor2, $task1));

/*
    Conditions:
        The task in the Running status

    Expected:
        Only its customer may confirm the task is done
*/
$task1 = new Task(Task::STATUS_RUNNING, $customer1, $contractor1);
assert($done->isValid($customer1, $task1));
assert(!$done->isValid($customer2, $task1));
assert(!$done->isValid($contractor1, $task1));
assert(!$done->isValid($contractor2, $task1));

/*
    Conditions:
        The task in the Failed status

    Expected:
        Only its customer may confirm the task is done
*/
$task1 = new Task(Task::STATUS_FAILED, $customer1, $contractor1);
assert(!$done->isValid($customer1, $task1));
assert(!$done->isValid($customer2, $task1));
assert(!$done->isValid($contractor1, $task1));
assert(!$done->isValid($contractor2, $task1));

/*
    Conditions:
        The task in the Done status

    Expected:
        No one may re-confirm the task is done
*/
$task1 = new Task(Task::STATUS_DONE, $customer1, $contractor1);
assert(!$done->isValid($customer1, $task1));
assert(!$done->isValid($customer2, $task1));
assert(!$done->isValid($contractor1, $task1));
assert(!$done->isValid($contractor2, $task1));
