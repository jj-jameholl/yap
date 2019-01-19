<?php
/**
 * Created by PhpStorm.
 * User: zhanhong01
 * Date: 2019/1/15
 * Time: 11:11
 */

namespace Base\Http\Controllers;

use PDOException;
use Phalcon\Mvc\Controller as BaseController;
use Phalcon\Mvc\Dispatcher;
use Throwable;

/**
 * Class Controller
 * @package app\Http\Controllers
 *
 * @property Redis $session
 */
class Controller extends BaseController
{
    public $name = 'Base/Controller';
    const DEFAULT_NAMESPACE = __NAMESPACE__;

    /**
     * @param array|\JsonSerializable $data
     * @param string $message
     * @return array
     */
    public function success($data = [], string $message = 'SUCCESS')
    {
        return [
            'code' => 0,
            'message' => $message,
            'data' => $data??new \stdClass(),
        ];
    }

    /**
     * @param int $code
     * @param string $message
     * @param array|\JsonSerializable $data
     * @return array
     */
    public function error(int $code = 500, string $message = 'error', $data = null)
    {
        return [
            'code' => $code,
            'message' => $message,
            'data' => $data??new \stdClass(),
        ];
    }

    /**
     * @param Dispatcher $dispatcher
     * @return mixed
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        $this->view->disable();
        $collection = $this->annotations->getMethod(
            $dispatcher->getControllerClass(),
            $dispatcher->getActionName() . $dispatcher->getActionSuffix()
        );

        /**
         * Action是否需要登录
         */
        if ($collection->has('MustLogin')
            && $collection->get('MustLogin')->getArgument(0)
            && true// 判断为未登录
        ) {
            /*$resp = $this->error(100, 'login first, please');
            $this->response->setJsonContent($resp, JSON_UNESCAPED_UNICODE);
            $dispatcher->setReturnedValue($this->response);
            return false;*/
            $dispatcher->setNamespaceName("Base\Http\Controllers\\");
            return $dispatcher->forward([
                'controller' => 'error',
                'action' => 'notLogin',
            ]);
        }
    }

    /**
     * @param Dispatcher $dispatcher
     * @return mixed
     */
    public function afterExecuteRoute(Dispatcher $dispatcher)
    {
        $response = $dispatcher->getReturnedValue();
        if (empty($response)) {
            $response = $this->error();
        }
        if (is_array($response)) {
            $this->response->setJsonContent($response, JSON_UNESCAPED_UNICODE);
        }

        //$this->response->setStatusCode(200);
        return $dispatcher->setReturnedValue($this->response);
    }

    /**
     * @param Throwable $e
     * @return array
     */
    public function throwError(Throwable $e)
    {
        $data = [];
        if (CONF_MODE !== 'produce') {
            $data = [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ];
        }
        $code = $e instanceof PDOException ? 99 : $e->getCode();
        return $this->error($code == 0 ? 500 : $code, $e->getMessage(), $data);
    }
}
