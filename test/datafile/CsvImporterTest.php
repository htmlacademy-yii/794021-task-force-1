<?php
namespace R794021\Test\Datafile\CsvImporter;

use R794021\DataFile\CSVImporter;


const FILENAME = 'test/datafile/import.csv';
const HEADERS = ['description', 'integer-number', 'float-number', 'theday'];
const WRONG_HEADERS = ['discription', 'integer', 'float', 'day'];
const FIRST_ROW = [
    'Мы 我们 We',
    '65536',
    '1.12345',
    '1970-02-29',
];
const SECOND_ROW = [
    "Я, 我; I'\\/",
    '-65537',
    '-1.12345',
    '1966-02-29',
];
const WRONG_FILENAME = 'abracadabra.csv';
const WRONG_FILENAME_EXCEPTION_TEXT =
    "File 'abracadabra.csv' cannot be opened";

// CSV Headers
$file = new CSVImporter(FILENAME);
assert($file->getHeaders() === HEADERS);
assert($file->getHeaders() !== WRONG_HEADERS);

// CSV Body
$rows = $file->getRows();
assert($rows[0] === FIRST_ROW);
assert($rows[0] !== SECOND_ROW);
assert($rows[1] === SECOND_ROW);
assert($rows[1] !== FIRST_ROW);
assert(count($rows) === 2);

// Inexisted file
try {
    $isProperException = false;
    $file = new CSVImporter(WRONG_FILENAME);
} catch (\Exception $e) {
    assert($e->getMessage() === WRONG_FILENAME_EXCEPTION_TEXT);
    $isProperException = true;
} finally {
    assert($isProperException);
}
