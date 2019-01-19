<?php
/**
 * Created by PhpStorm.
 * User: zhanhong01
 * Date: 2019/1/11
 * Time: 17:48
 */
namespace App\Models;

use Phalcon\Mvc\Model as PhalconModel;

class Model extends PhalconModel
{
    protected $database = ''; // 数据库名称

    public function initialize()
    {
        $this->setConnectionService('db.'.$this->database);
    }
}