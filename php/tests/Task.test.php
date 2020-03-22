<?php

namespace R794021;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';


/*
 * Prequisites for the testing
 */
ini_set('display_errors', 1);
ini_set('assert.exception', '1');
assert(ini_get('zend.assertions') === '1', 'Php.ini should set "zend.assertions" to string "1"');


/*
 * Tests
 */

// Testing of 'NEW' status

$task = new Task(Task::STATUS_NEW, 1, 2);

assert($task->getStatus() === Task::STATUS_NEW,
    'After creating the task must be in "STATUS_NEW"'
);

assert($task->getNextStatus(Task::ACTION_CANCEL) === Task::STATUS_CANCELLED,
    'If dispatched "ACTION_CANCEL" it should change the status to "STATUS_CANCEL"'
);

assert($task->getNextStatus(Task::ACTION_APPLY) === Task::STATUS_RUNNING,
    'If dispatched "ACTION_APPLY" it should change the status to "STATUS_RUNNING"'
);


// Testing of 'CANCELLED' status

$task = new Task(Task::STATUS_NEW, 1, 2);
$task->dispatch(Task::ACTION_CANCEL);
assert($task->getStatus() === Task::STATUS_CANCELLED,
    'Dispatching "ACTION_CANCEL" should change the status to "STATUS_CANCEL"'
);


// Testing of 'RUNNING' status

$task = new Task(Task::STATUS_NEW, 1, 2);
$task->dispatch(Task::ACTION_APPLY);
assert($task->getStatus() === Task::STATUS_RUNNING,
    'Dispatching "ACTION_APPLY" should change the status to "STATUS_RUNNING"'
);

assert($task->getNextStatus(Task::ACTION_CONFIRM_DONE) === Task::STATUS_DONE,
    'If dispatched "ACTION_CONFIRM_DONE" it should change the status to "STATUS_DONE"'
);

assert($task->getNextStatus(Task::ACTION_REJECT) === Task::STATUS_FAILED,
    'if dispatched "ACTION_REJECT" it should change the status to "STATUS_FAILED"'
);


// Testing of 'DONE' status

$task = new Task(Task::STATUS_NEW, 1, 2);
$task->dispatch(Task::ACTION_APPLY);
$task->dispatch(Task::ACTION_CONFIRM_DONE);
assert($task->getStatus() === Task::STATUS_DONE,
    'Dispatching "ACTION_CONFIRM_DONE" should change the status to "STATUS_DONE"'
);


// Testing of 'FAILED' status

$task = new Task(Task::STATUS_NEW, 1, 2);
$task->dispatch(Task::ACTION_APPLY);
$task->dispatch(Task::ACTION_REJECT);
assert($task->getStatus() === Task::STATUS_FAILED,
    'Dispatching "ACTION_REJECT" should change the status to "STATUS_FAILED"'
);
