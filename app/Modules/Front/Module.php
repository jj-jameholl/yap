<?php
/**
 * Created by PhpStorm.
 * User: zhanhong01
 * Date: 2019/1/9
 * Time: 10:43
 */

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Annotations\Factory;
use Phalcon\Annotations\Adapter\Files;
use Phalcon\Annotations\Adapter\Memory;
use Phalcon\Annotations\Annotation;

class Module implements ModuleDefinitionInterface
{

    /**
     * 注册自定义加载器
     */
    public function registerAutoloaders(\Phalcon\DiInterface $di = NULL)
    {
        $loader = $di->get('autoloader');
        $loader->registerNamespaces(array(
            'Repositories' => __DIR__ . '/Repositories',
        ));
        $loader->register();
    }


    /**
     * 注册自定义服务
     */
    public function registerServices(\Phalcon\DiInterface $di = NULL)
    {

    }
}
