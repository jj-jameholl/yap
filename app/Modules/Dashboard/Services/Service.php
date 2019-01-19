<?php
/**
 * Created by PhpStorm.
 * User: zhanhong01
 * Date: 2019/1/16
 * Time: 17:48
 */

namespace Services;

use App\Services\Container;

class Service
{
    public function get($name)
    {
        return Container::get($name);
    }
}