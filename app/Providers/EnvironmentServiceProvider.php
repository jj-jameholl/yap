<?php
/**
 * Created by PhpStorm.
 * User: zhoutianliang01
 * Date: 2018/9/28
 * Time: 15:37
 */

namespace App\Providers;

use Phalcon\Config;
use Phalcon\Di\ServiceProviderInterface;

class EnvironmentServiceProvider implements ServiceProviderInterface
{

    public function register(\Phalcon\DiInterface $di)
    {
        // TODO: Implement register() method.
        $di->set('config', function () {
            $path = $this->get('path');

            $config = require $path->config . DIRECTORY_SEPARATOR . 'default.php';
            $env = $path->config . DIRECTORY_SEPARATOR . sprintf("%s.php", CONF_MODE);
            if (file_exists($env)) {
                $config = array_merge($config, require $env);
            }
            return new Config($config);
        }, true);
    }
}
