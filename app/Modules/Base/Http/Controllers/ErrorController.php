<?php
/**
 * Created by PhpStorm.
 * User: zhanhong01
 * Date: 2019/1/15
 * Time: 11:09
 */

namespace Base\Http\Controllers;

/**
 * Class ErrorController
 * @package Base\Http\Controllers
 * @RoutePrefix('/sv/base/error/')
 * @Module('Base')
 */
class ErrorController extends Controller
{
    /**
     * @return array
     * @Route('test')
     */
    public function notFoundAction()
    {
        return $this->error(200, "未知路径！");
    }

    /**
     *
     */
    public function notLoginAction()
    {
        return $this->error(100, "login first, please");
    }


    public function unavailableAction($info)
    {
        return $this->error(101, $info);
    }
}
