<?php
use R794021\Task\Task;
use R794021\User\{Contractor, Customer, User};
use R794021\Action\
    {AbstractAction, Action, ApplyAction, CancelAction, DoneAction, RejectAction};
use R794021\Exception\DataDomainException;

const UNEXISTING_TASK_STATUS = 'This status is fictuous';
const UNEXISTING_TASK_STATUS_EXCEPTION_TEXT = 'Task status should be one of the list';
const SAME_PERSON_EXCEPTION_TEXT = 'Contractor cannot be a customer of the same task';
const UNEXISTING_ACTION_EXCEPTION_TEXT = 'Unknown action for the task';

$customer = new Customer(CUSTOMER_1);
$contractor = new Contractor(CONTRACTOR_1);
$contractorWithCustomer1Id = new Contractor(CUSTOMER_1);

// Testing of 'NEW' status
$task = new Task(Task::STATUS_NEW, $customer);
assert($task->getStatus() === Task::STATUS_NEW);
assert(! $task->isRunning());
assert($task->getCustomer() == $customer);
assert(! $task->getContractor());

// Testing of 'CANCELLED' status
$task = new Task(Task::STATUS_CANCELLED, $customer, $contractor);
assert($task->getStatus() === Task::STATUS_CANCELLED);
assert(! $task->isRunning());
assert($task->getCustomer() == $customer);
assert($task->getContractor() == $contractor);
assert($task->getCustomer() !== $task->getContractor());

// Testing of 'RUNNING' status
$task = new Task(Task::STATUS_RUNNING, $customer, $contractor);
assert($task->getStatus() === Task::STATUS_RUNNING);
assert($task->isRunning());
assert($task->getCustomer() == $customer);
assert($task->getContractor() == $contractor);
assert($task->getCustomer() !== $task->getContractor());

// Testing of 'DONE' status
$task = new Task(Task::STATUS_DONE, $customer, $contractor);
assert($task->getStatus() === Task::STATUS_DONE);
assert(! $task->isRunning());
assert($task->getCustomer() == $customer);
assert($task->getContractor() == $contractor);
assert($task->getCustomer() !== $task->getContractor());

// Testing of 'FAILED' status
$task = new Task(Task::STATUS_FAILED, $customer, $contractor);
assert($task->getStatus() === Task::STATUS_FAILED);
assert(! $task->isRunning());
assert($task->getCustomer() == $customer);
assert($task->getContractor() == $contractor);
assert($task->getCustomer() !== $task->getContractor());

// Testing of 'getNextStatus' status
assert($task->getNextStatus(new ApplyAction()) === Task::STATUS_RUNNING);
assert($task->getNextStatus(new CancelAction()) === Task::STATUS_CANCELLED);
assert($task->getNextStatus(new DoneAction()) === Task::STATUS_DONE);
assert($task->getNextStatus(new RejectAction()) === Task::STATUS_FAILED);

//Testing of unexisted status
try {
    $task = new Task(UNEXISTING_TASK_STATUS, $customer, $contractor);
} catch (DataDomainException $e) {
    assert($e->getMessage() === UNEXISTING_TASK_STATUS_EXCEPTION_TEXT );
}

//Testing if contractor is the same person as the customer
try {
    $task = new Task(Task::STATUS_NEW, $customer, $contractorWithCustomer1Id);
} catch (DataDomainException $e) {
    assert($e->getMessage() === SAME_PERSON_EXCEPTION_TEXT);
}

try {
    $task = new Task(Task::STATUS_RUNNING, $customer, $contractorWithCustomer1Id);
} catch (DataDomainException $e) {
    assert($e->getMessage() === SAME_PERSON_EXCEPTION_TEXT );
}

try {
    $task = new Task(Task::STATUS_CANCELLED, $customer, $contractorWithCustomer1Id);
} catch (DataDomainException $e) {
    assert($e->getMessage() === SAME_PERSON_EXCEPTION_TEXT );
}

try {
    $task = new Task(Task::STATUS_DONE, $customer, $contractorWithCustomer1Id);
} catch (DataDomainException $e) {
    assert($e->getMessage() === SAME_PERSON_EXCEPTION_TEXT );
}

try {
    $task = new Task(Task::STATUS_FAILED, $customer, $contractorWithCustomer1Id);
} catch (DataDomainException $e) {
    assert($e->getMessage() === SAME_PERSON_EXCEPTION_TEXT );
}

// Checking unexisted action class
$unexistingAction = new class extends AbstractAction implements Action
{
    public function isValid(User $user, Task $task): bool
    {
        return false;
    }
};

try {
    $task->getNextStatus($unexistingAction);
} catch (DataDomainException $e) {
    assert( $e->getMessage() === UNEXISTING_ACTION_EXCEPTION_TEXT );
}
