<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //加载错误信息
    dd($e->getMessage());
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
| 我们将会加载环境并且创建一个应用实例
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/
// realpath _ private/var/www/blog
//去加载Container 传参数 basePath[核心]
$app = new Laravel\Lumen\Application(
    realpath(__DIR__ . '/../')
);

//lumen的门面
$app->withFacades();
//是否开启orm
//$app->withEloquent();
//可以自己来写
$app->Test();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/
//注册异常类
$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);
//注册调试行
$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/
//注册laravel debugger
if (env('APP_DEBUG')) {
    $app->register(Barryvdh\Debugbar\LumenServiceProvider::class);
}
//配置debugbar
$app->configure('debugbar');




//配置database
$app->configure('database');


//注册MiddleWare,使用example中间件,所有的路由都会经过这层
$app->middleware([
    App\Http\Middleware\BeforeMiddleware::class,
    App\Http\Middleware\GodMiddleware::class,

]);

//如果是路由中间件的话,那么使用 'key' => 'value' 的形式进行注册
$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
    'example' => App\Http\Middleware\ExampleMiddleware::class
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers 注册服务提供者
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/
//注册服务提供者
$app->register(App\Providers\AppServiceProvider::class);
//$app->register(App\Providers\AuthServiceProvider::class);
//$app->register(App\Providers\EventServiceProvider::class);
$app->register(App\Providers\ExampleServiceProvider::class);
//注册redis服务提供者
$app->register(Illuminate\Redis\RedisServiceProvider::class);
/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->group(['namespace' => 'App\Http\Controllers'], function ($app) {
    require __DIR__ . '/../app/Http/routes.php';
});

return $app;
