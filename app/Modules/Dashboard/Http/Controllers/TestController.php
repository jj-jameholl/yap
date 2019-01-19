<?php
/**
 * Created by PhpStorm.
 * User: zhanhong01
 * Date: 2019/1/9
 * Time: 14:14
 */

namespace Dashboard\Http\Controllers;

use Base\Http\Controllers\Controller;
use \testRepository;

/**
 * Class TestController
 * @package Modules\Dashboard\Http\Controllers
 * @RoutePrefix("/sv/dashboard/test/")
 * @Module("Dashboard")
 */
class TestController extends Controller
{

    protected $testRepostitory;

    public function initialize()
    {
        $this->testRepostitory = new testRepository();
    }


    /**
     * @return array
     * @Route('index')
     * @MustLogin(false)
     */
    public function indexAction()
    {
        try {
            $rtn = $this->testRepostitory->test();
            return $this->success($rtn);
        } catch (\Exception $e) {
            return $this->throwError($e);
        }
    }
}