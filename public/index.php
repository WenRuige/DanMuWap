<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| First we need to get an application instance. This creates an instance
| of the application / container and bootstraps the application so it
| is ready to receive HTTP / Console requests from the environment.
|
*/
//将默认session 改为redis
ini_set('session.save_handler', 'redis');
ini_set('session.save_path', 'tcp://127.0.0.1:6379');
session_start();
//定义主依赖的位置
define('SERVICE_PATH', __DIR__ . '/../../coreservice');
//引入依赖文件
require SERVICE_PATH.'/vendor/autoload.php';
//加载bootstrap的 app.php文件
$app = require __DIR__ . '/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

//加载依赖库

//spl_auto_load动态加载主库
function serviceAutoload($className)
{

    $nameArr = explode('\\', $className);
    if ($nameArr[0] == 'core') {
        $filePath = SERVICE_PATH . '/' . implode(DIRECTORY_SEPARATOR, $nameArr) . '.php';
        if (file_exists($filePath)) {
            require_once $filePath;
            return true;
        }
    }
    return false;
}

$redis = new redis();
$redis->connect('127.0.0.1', 6379);
//$data = $redis->lIndex('queue',0);
//dd(json_decode($data));
//$data = explode('',$data)
spl_autoload_register("serviceAutoload");
$app->run();
