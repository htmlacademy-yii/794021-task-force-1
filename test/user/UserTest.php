<?php
namespace Test\User\UserTest;

use R794021\User\User;
use R794021\Exception\DataDomainException;

const USER_ID_FIELD_NOT_POSITIVE_INTEGER = ['id' => '-1.0'];
const USER_HAS_NO_ID_FIELD = ['idd' => 1];
const USER_HAS_NO_ID_FIELD_EXCEPTION_TEXT = 'User id field should exist';
const USER_ID_FIELD_NOT_POSITIVE_INTEGER_EXCEPTION_TEXT =
    'User id must be positive integer';

// Test if 'id' field exist in user data
try {
    $hasException = false;
    $user = new class (USER_HAS_NO_ID_FIELD) extends User {
        public static function isContractor(): bool { return false; }
        public static function isCustomer(): bool { return false; }
    };
} catch (DataDomainException $e) {
    $hasException = true;
    assert($e->getMessage() === USER_HAS_NO_ID_FIELD_EXCEPTION_TEXT);
} finally {
    assert($hasException, 'There must be exception!');
}

// Test if 'id' field is a positive integer
try {
    $hasException = false;
    $user = new class (USER_ID_FIELD_NOT_POSITIVE_INTEGER) extends User {
        public static function isContractor(): bool { return false; }
        public static function isCustomer(): bool { return false; }

    };
} catch (DataDomainException $e) {
    $hasException = true;
    assert($e->getMessage() === USER_ID_FIELD_NOT_POSITIVE_INTEGER_EXCEPTION_TEXT);
} finally {
    assert($hasException, 'There must be exception!');
}
