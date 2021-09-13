<?php
namespace Test\yii\frontend\models\CityTest;

use frontend\models\City;

const TABLE_NAME = 'city';
const MAX_ID = 1000;

$model = new City();

// Tests
assert($model->tableName() === TABLE_NAME);

$rules = $model->rules();
assert(is_array($rules));
assert(count($rules) > 0);

$attributeLabels = $model->attributeLabels();
assert(is_array($attributeLabels));
assert(count($attributeLabels) > 0);

$city = City::findOne(MAX_ID);
assert(gettype($city->name) === 'string');
assert(gettype($city->latitude) === 'string'); // Sic! Numeric MySQL become string in PHP/Yii
assert(gettype($city->longitude) === 'string'); // Sic! Numeric MySQL become string in PHP/Yii
