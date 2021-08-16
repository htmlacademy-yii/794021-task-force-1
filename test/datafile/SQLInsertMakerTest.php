<?php
namespace R794021\Test\Datafile\SQLInsertMaker;

use R794021\DataFile\SQLInsertMaker;


const TABLE_NAME = 'people';

const HEADERS_1 = ['surname', 'day', 'cost'];
const VALUES_1 = ['Name Мы 我们', '1968-02-29', 1.234567];
const VALUES_2 = ['Name Я 我', '1886-02-29', -1.234567];
const ROWS = [VALUES_1, VALUES_2];
const RESULT_STATEMENT =
    'INSERT INTO people (surname, day, cost) VALUES ("Name Мы 我们", "1968-02-29", "1.234567");' . PHP_EOL .
    'INSERT INTO people (surname, day, cost) VALUES ("Name Я 我", "1886-02-29", "-1.234567");' . PHP_EOL;

// Main case
$sqlStatement = SQLInsertMaker::make(TABLE_NAME, HEADERS_1, ROWS);
assert($sqlStatement === RESULT_STATEMENT);
