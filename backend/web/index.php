<?php
echo "1";
try {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
    echo "2";
    require __DIR__ . '/vendor/autoload.php';
    require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
    require __DIR__ . '/common/config/bootstrap.php';
    require __DIR__ . '/api/config/bootstrap.php';
    echo "3";
    $config = yii\helpers\ArrayHelper::merge(
        require __DIR__ . '/common/config/main.php',
        require __DIR__ . '/common/config/main-local.php',
        require __DIR__ . '/api/config/main.php',
        require __DIR__ . '/api/config/main-local.php'
    );
    echo "4";
    (new yii\web\Application($config))->run();
    echo "5";
}catch (Exception $e){
    echo "6";
    echo $e;
}
