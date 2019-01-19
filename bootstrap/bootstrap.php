<?php
/**
 * Created by PhpStorm.
 * User: zhanhong01
 * Date: 2019/1/9
 * Time: 9:19
 */

use App\Application;

require __DIR__ . '/../vendor/autoload.php';

$app = new Application(realpath(__DIR__ . '/../'));

return $app;