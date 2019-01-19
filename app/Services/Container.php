<?php
/**
 * Created by PhpStorm.
 * User: zhanhong01
 * Date: 2019/1/16
 * Time: 18:36
 */

namespace App\Services;


use Phalcon\Di;
/**
 * Class Container
 * @package App\Services
 */
final class Container
{
    /**
     * @var array
     */
    private static $container = [];

    /**
     * @param string $name
     * @return \Redis|Mysql|Request|File|Redis|Config|Manager
     */
    public static function get(string $name)
    {
        if (!isset(self::$container[$name])) {
            self::$container[$name] = Di::getDefault()->get($name);
        }

        return self::$container[$name];
    }

    public static function test()
    {
        return Di::getDefault();
    }
}