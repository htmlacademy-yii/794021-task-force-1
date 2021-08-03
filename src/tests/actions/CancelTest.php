<?php

use R794021\Actions\Cancel;
use R794021\Tasks\Task;
use R794021\Users\Contractor;
use R794021\Users\Customer;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$cancel = new Cancel();
$customer1 = new Customer(CUSTOMER_1);
$contractor1 = new Contractor(CONTRACTOR_1);
$customer2 = new Customer(CUSTOMER_2);
$contractor2 = new Contractor(CONTRACTOR_2);

/*
    Checking the name of the Action
 */
assert($cancel->getName() === 'Отменить');
assert($cancel->getName() !== ' Отменить');

/*
    Checking the internal codename of the Action
 */
assert($cancel->getInternalCodename() === 'cancel');
assert($cancel->getInternalCodename() !== 'apply');

/*
    Conditions:
        The task in the 'NEW' status

    Expected:
        Only its customer can dispatch 'Cancel' action
*/
$task1 = new Task(Task::STATUS_NEW, $customer1);
assert($cancel->isValid($customer1, $task1));
assert(! $cancel->isValid($customer2, $task1));
assert(! $cancel->isValid($contractor1, $task1));
assert(! $cancel->isValid($contractor2, $task1));

/*
    Conditions:
        The task is started

    Expected:
        No user can cancel the task
*/
$task1 = new Task(Task::STATUS_RUNNING, $customer1, $contractor1);
assert(! $cancel->isValid($customer1, $task1));
assert(! $cancel->isValid($customer2, $task1));
assert(! $cancel->isValid($contractor1, $task1));
assert(! $cancel->isValid($contractor2, $task1));

/*
    Conditions:
        The task is in the cancelled status

    Expected:
        No one can cancel the task
*/
$task1 = new Task(Task::STATUS_CANCELLED, $customer1, $contractor1);
assert(! $cancel->isValid($customer1, $task1));
assert(! $cancel->isValid($customer2, $task1));
assert(! $cancel->isValid($contractor1, $task1));
assert(! $cancel->isValid($contractor2, $task1));

/*
    Conditions:
        The task is done

    Expected:
        No one can cancel the task the second time
*/
$task1 = new Task(Task::STATUS_DONE, $customer1, $contractor1);
assert(! $cancel->isValid($customer1, $task1));
assert(! $cancel->isValid($customer2, $task1));
assert(! $cancel->isValid($contractor1, $task1));
assert(! $cancel->isValid($contractor2, $task1));

/*
    Conditions:
        The task is failed

    Expected:
        No one can cancel the task the second time
*/
$task1 = new Task(Task::STATUS_DONE, $customer1, $contractor1);
assert(! $cancel->isValid($customer1, $task1));
assert(! $cancel->isValid($customer2, $task1));
assert(! $cancel->isValid($contractor1, $task1));
assert(! $cancel->isValid($contractor2, $task1));