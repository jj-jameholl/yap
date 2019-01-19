<?php
/**
 * Created by PhpStorm.
 * User: zhanhong01
 * Date: 2019/1/9
 * Time: 20:22
 */

namespace Front\Http\Controllers;

use Base\Http\Controllers\Controller;

/**
 * Class TestController
 * @package Modules\Front\Http\Controllers
 * @RoutePrefix("/sv/front/test")
 * @Module("Front")
 */
class TestController extends Controller
{
    /**
     * @Route("/index")
     * @MustLogin(true)
     */
    public function indexAction()
    {
        return $this->success();
    }

    /**
     * @Route("/index2")
     */
    public function index2Action()
    {
        print_r("hello phalcon");
        exit;
    }
}