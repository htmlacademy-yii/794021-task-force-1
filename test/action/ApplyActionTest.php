<?php
namespace Test\Action\ApplyActionTest;

use R794021\Action\ApplyAction;
use R794021\Task\Task;
use R794021\User\{Customer, Contractor};

const CUSTOMER_1 = ['id' => 12];
const CUSTOMER_2 = ['id' => 13];
const CONTRACTOR_1 = ['id' => 24];
const CONTRACTOR_2 = ['id' => 26];


$apply = new ApplyAction();
$customer1 = new Customer(CUSTOMER_1);
$customer2 = new Customer(CUSTOMER_2);
$contractor1 = new Contractor(CONTRACTOR_1);
$contractor2 = new Contractor(CONTRACTOR_2);

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
        Only users with 'Contractor' class can apply
 */
$task = new Task(Task::STATUS_NEW, $customer1);
assert(!$apply->isValid($customer1, $task));
assert(!$apply->isValid($customer2, $task));
assert($apply->isValid($contractor1, $task));
assert($apply->isValid($contractor2, $task));

/*
    Conditions:
        The task is in the Running status
    Expected:
        No one can apply for the already running task
 */
$task = new Task(Task::STATUS_RUNNING, $customer1, $contractor1);
assert(!$apply->isValid($contractor1, $task));
assert(!$apply->isValid($contractor2, $task));
assert(!$apply->isValid($customer1, $task));
assert(!$apply->isValid($customer2, $task));

/*
    Conditions:
        The task is in the Done status
    Expected:
        No one can apply for the already running task
 */
$task = new Task(Task::STATUS_DONE, $customer1, $contractor1);
assert(!$apply->isValid($contractor1, $task));
assert(!$apply->isValid($contractor2, $task));
assert(!$apply->isValid($customer1, $task));
assert(!$apply->isValid($customer2, $task));

/*
    Conditions:
        The task is in the Failed status
    Expected:
        No one can apply for the already running task
 */
$task = new Task(Task::STATUS_FAILED, $customer1, $contractor1);
assert(!$apply->isValid($contractor1, $task));
assert(!$apply->isValid($contractor2, $task));
assert(!$apply->isValid($customer1, $task));
assert(!$apply->isValid($customer2, $task));
