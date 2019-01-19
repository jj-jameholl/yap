<?php
/**
 * Created by PhpStorm.
 * User: zhoutianliang01
 * Date: 2018/9/28
 * Time: 13:41
 */

use Phalcon\Loader;

$loader = new Loader();

$file = __DIR__ . '/../vendor/composer/autoload_psr4.php';

if (file_exists($file)) {
    $namespaces = require $file;
    $registerNamespaces = [];
    foreach ($namespaces as $namespace => $dir) {
        $registerNamespaces[trim($namespace, '/\\')] = $dir[0];
    }
    $loader->registerNamespaces($registerNamespaces);
}
$loader->register();

$file = __DIR__ . '/../vendor/composer/autoload_files.php';

if (file_exists($file)) {
    $loader->registerFiles(require $file)->loadFiles();
}