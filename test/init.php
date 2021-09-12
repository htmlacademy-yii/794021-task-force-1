<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require './vendor/yiisoft/yii2/Yii.php';
require './common/config/bootstrap.php';
require './frontend/config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require './common/config/main.php',
    require './common/config/main-local.php',
    require './frontend/config/main.php',
    require './frontend/config/main-local.php'
);

(new yii\web\Application($config));

const CUSTOMER_1 = ['id' => 12];
const CUSTOMER_2 = ['id' => 13];
const CONTRACTOR_1 = ['id' => 24];
const CONTRACTOR_2 = ['id' => 26];

const USER_HAS_NO_ID_FIELD = ['idd' => 1];
const USER_ID_FIELD_NOT_POSITIVE_INTEGER = ['id' => '-1.0'];
