<?php
namespace R794021\Test\app\model;

use frontend\models\User;

const TABLE_NAME = 'user';
const MAX_USER_ID = 20;

// Initialisation
$userModel = new User();

// Tests
assert($userModel->tableName() === TABLE_NAME);

$rules = $userModel->rules();
assert(is_array($rules));
assert(count($rules) > 0);

$attributeLabels = $userModel->attributeLabels();
assert(is_array($attributeLabels));
assert(count($attributeLabels) > 0);


// TODO
$user = User::findOne(MAX_USER_ID);
assert(gettype($user->fullname) === 'string');
assert(gettype($user->email) === 'string');
assert(gettype($user->password_hash) === 'string');
assert(gettype($user->city_id) === 'integer');
