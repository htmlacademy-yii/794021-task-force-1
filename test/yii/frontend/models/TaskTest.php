<?php
namespace Test\yii\frontend\models\TaskTest;

use frontend\models\Task;

const TABLE_NAME = 'task';
const MAX_ID = 10;
const MAX_LATITUDE = 180;
const MIN_LATITUDE = -180;

$model = new Task();

// Tests
assert($model->tableName() === TABLE_NAME);

$rules = $model->rules();
assert(is_array($rules));
assert(count($rules) > 0);

$attributeLabels = $model->attributeLabels();
assert(is_array($attributeLabels));
assert(count($attributeLabels) > 0);

$task = Task::findOne(MAX_ID);
assert(gettype($task->title) === 'string');
assert(gettype($task->text) === 'string');
assert(gettype($task->address) === 'string');
assert(gettype($task->latitude) === 'string'); // Sic! Numeric MySQL becomes string in PHP/Yii
assert(gettype($task->longitude) === 'string'); // Sic! Numeric MySQL becomes string in PHP/Yii

$latitude = (double) $city->latitude;
assert($latitude <= MAX_LATITUDE && $latitude >= MIN_LATITUDE);
