<?php
/**
 * Created by PhpStorm.
 * User: zhanhong01
 * Date: 2019/1/9
 * Time: 11:05
 */

namespace App\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Mvc\View;

class BaseServiceProvider implements ServiceProviderInterface
{
    public function register(\Phalcon\DiInterface $di)
    {
        // TODO: Implement register() method.
        $di->set('view', function () {
            return new View();
        });

        $di->set('filter', function () {
            return new \Phalcon\Filter();
        });

        //模块注册命名空间时需要用到
        $di->set('autoloader', function () {
            return new \Phalcon\Loader();
        });
    }
}