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
