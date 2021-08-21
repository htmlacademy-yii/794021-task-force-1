<?php
namespace R794021\Test\Datafile\DataTable;

use R794021\DataFile\DataTable;

const HEADERS = ['date', 'score'];
const ROWS = [
    ['2021-01-01', 5],
    ['1969-01-01', 1],
];
const HEADERS_RESULT = ['day', 'marks'];

const HEADERS_NEW = ['date' => 'day', 'score' => 'marks'];
const HEADERS_INEXISTING = ['foo' => 'bar'];

const FAKE_HEADER = 'fake_id';
const FAKE_VALUE_LIMIT = 2;
const FAKE_FIELDS = [FAKE_HEADER => FAKE_VALUE_LIMIT];
const HEADERS_WITH_FAKE_DATA =  ['date', 'score', 'fake_id'];

const SAME_HEADERS_FAKE_DATA = ['date' => 123];

// Creation
$table = new DataTable(HEADERS, ROWS);
assert($table->getHeaders() === HEADERS);
assert($table->getRows() === ROWS);

$table = new DataTable(HEADERS, []);
assert($table->getHeaders() === HEADERS);
assert($table->getRows() === []);

$table = new DataTable(HEADERS);
assert($table->getHeaders() === HEADERS);
assert($table->getRows() === []);

$table = new DataTable([]);
assert($table->getHeaders() === []);
assert($table->getRows() === []);

$table = new DataTable();
assert($table->getHeaders() === []);
assert($table->getRows() === []);

// Change header existing
$table = new DataTable(HEADERS, ROWS);
$table->renameHeaders(HEADERS_NEW);
assert($table->getHeaders() === HEADERS_RESULT);

// Change header inxisting
$table = new DataTable(HEADERS, ROWS);
$table->renameHeaders(HEADERS_INEXISTING);
assert($table->getHeaders() === HEADERS);
assert($table->getRows() === ROWS);

// Add generated data
for ($i = 1; $i < 100000; $i++) {
    $table = new DataTable(HEADERS, ROWS);
    $table->addFakeData(FAKE_FIELDS);
    assert($table->getHeaders() === HEADERS_WITH_FAKE_DATA);
    foreach($table->getRows() as $row) {
        assert($row[count($row) - 1] <= FAKE_VALUE_LIMIT);
    }
}

// Prerserve existing data
$table = new DataTable(HEADERS, ROWS);
$table->addFakeData(SAME_HEADERS_FAKE_DATA);
assert($table->getHeaders() === HEADERS);
assert($table->getRows() === ROWS);

$table->addFakeData([]);
assert($table->getHeaders() === HEADERS);
assert($table->getRows() === ROWS);

$table->addFakeData();
assert($table->getHeaders() === HEADERS);
assert($table->getRows() === ROWS);
