<?php

/*
    The script runs all the test files with '.test.php' extension
    which reside in the current folder and downwards recursively
 */

declare(strict_types = 1);

if ( $_SERVER['DOCUMENT_ROOT'] !== '') {
    die('Tests must be run under CLI command: "composer test"');
}

require_once './vendor/autoload.php';
require_once 'init.php';

ini_set('display_errors', '1');
ini_set('assert.exception', '1');
$zendAssertionSetting = ini_get('zend.assertions');
if ( $zendAssertionSetting !== '1' ) {
    throw new \Error(
        "Php.ini should set 'zend.assertions' to string '1',
        but '$zendAssertionSetting' is set"
    );
}

// Include all matching files recursively
$directory = new \RecursiveDirectoryIterator(__DIR__);
$iterator = new \RecursiveIteratorIterator($directory);
$files = new \RegexIterator(
    $iterator,
    '/^.+Test.php$/i',
    RecursiveRegexIterator::GET_MATCH
);

foreach ($files as $file) {
    $filename = basename($file[0]);
    echo "Start tests in: '$filename'" . PHP_EOL;
    include $file[0];
    echo 'Passed' . PHP_EOL;
}
