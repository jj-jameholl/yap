<?php
/**
 * Created by PhpStorm.
 * User: zhoutianliang01
 * Date: 2018/9/28
 * Time: 15:39
 */

namespace App\Providers;

use Phalcon\Di\ServiceProviderInterface;

class RedisServiceProvider implements ServiceProviderInterface
{
    public function register(\Phalcon\DiInterface $di)
    {
        // TODO: Implement register() method.

        $config = $di->get("config");
        foreach ($config->redis as $name => $option) {
            $di->set('redis.' . $name, function () use ($option) {
                $redis = new \Redis();
                if (isset($option->socket) && $option->socket) {
                    $redis->connect($option->socket);
                } else {
                    $redis->connect(
                        $option->host,
                        $option->port??6379,
                        $option->timeout??1
                    );
                }
                return $redis;
            }, true);
        }
    }
}
