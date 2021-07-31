<?php

// Initialisation
ini_set('display_errors', 1);
ini_set('assert.exception', 1);
$zendAssertion = ini_get('zend.assertions');
if ( $zendAssertion !== '1' ) {
    throw new \Error("Php.ini should set 'zend.assertions' to string '1', but '$zendAssertion' is set");
}

// Include all '.test.php' files recursively
$directory = new \RecursiveDirectoryIterator('.');
$iterator = new \RecursiveIteratorIterator($directory);
$files = new \RegexIterator($iterator, '/^.+\.test.php$/i', RecursiveRegexIterator::GET_MATCH);

foreach ($files as $file) {
    echo "Start tests for: " . basename($file[0]) . "<br>";
    include $file[0];
    echo 'Passed<br><br>';
}
