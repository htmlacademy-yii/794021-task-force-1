<?php
use frontend\models\User;

$user = new User();

assert($user->tableName() === 'user');

$rules = $user->rules();
assert(is_array($rules));

$attributeLabels = $user->attributeLabels();
assert(is_array($attributeLabels));

$city = $user->getCity(); // TODO - Error 'Class Yii not found'
