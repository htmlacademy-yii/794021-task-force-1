<?php

/*
    The script runs all the test files with '.test.php' extension
    which reside from the current folder recursively
 */

// Initialisation
$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'] == '' ? '.' : $_SERVER['DOCUMENT_ROOT'];
ini_set('display_errors', 1);
ini_set('assert.exception', 1);
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
$files = new \RegexIterator($iterator, '/^.+\.test.php$/i', RecursiveRegexIterator::GET_MATCH);

foreach ($files as $file) {
    echo "Start tests for: " . basename($file[0]) . "<br>" . PHP_EOL;
    include $file[0];
    echo 'Passed<br><br>' . PHP_EOL . PHP_EOL;
}
