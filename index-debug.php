<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

//defined('YII_DEBUG') or define('YII_DEBUG', false);
//defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/common/config/env.php';
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/common/config/bootstrap.php';
require __DIR__ . '/frontend/config/bootstrap.php';

try {
    $config = yii\helpers\ArrayHelper::merge(
        require __DIR__ . '/common/config/main.php',
        require __DIR__ . '/common/config/main-local.php',
        require __DIR__ . '/frontend/config/main.php',
        require __DIR__ . '/frontend/config/main-local.php'
    );
    
    echo "Config loaded successfully\n";
    
    $app = new yii\web\Application($config);
    echo "Application created successfully\n";
    
    $app->run();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString();
} catch (Throwable $e) {
    echo "Fatal Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString();
}