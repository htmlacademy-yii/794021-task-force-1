<?php

/*
    The script runs all the test files with '.test.php' extension
    which reside in the current folder and downwards recursively
 */

// Initialisation
if ( $_SERVER['DOCUMENT_ROOT'] == '') {
    $eol = PHP_EOL;
    $_SERVER['DOCUMENT_ROOT'] = '.';
} else {
    $eol = '<br>';
}

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
    $filename = basename($file[0]);
    echo "Start tests in: '$filename' $eol";
    include $file[0];
    echo 'Passed' . $eol;
}
