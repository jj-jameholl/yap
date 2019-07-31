<?php
/**
 * 框架抽象接口及常用全局函数
 *
 */

function app()
{
    global $app;
    return $app;
}

function db($name = 'default')
{
    $db = app()->getDI()->get("db." . $name);

    if ($db == false) {
        throw new \Exception("Database not exists [name: $name]");
    }

    return $db;
}

function today()
{
    return date("Y-m-d");
}

function now()
{
    return date("Y-m-d H:i:s");
}


//我这里加一个注释哈
