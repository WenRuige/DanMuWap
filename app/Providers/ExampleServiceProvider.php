<?php
namespace App\Providers;

use App\Model\User;
use Illuminate\Support\ServiceProvider;

//服务层可以加载全局需要的组件,example
class ExampleServiceProvider extends ServiceProvider
{

    //todo:服务层的作用是去加载model
    //使用单利模式
    public function register()
    {
        $this->app->singleton('App\Model\User', function ($app) {
            return new User($app);
        });
        //已经被加载到服务层了
    }
}