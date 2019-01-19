<?php
/**
 * Created by PhpStorm.
 * User: zhanhong01
 * Date: 2019/1/11
 * Time: 11:10
 */

namespace App\Listeners;

use Exception;
use Phalcon\Dispatcher;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

class DispatcherListener extends Plugin
{

    public function beforeDispatchLoop(Event $event, Dispatcher $dispatcher)
    {

    }

    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {

    }

    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {

    }

    public function afterExecuteRoute(Event $event, Dispatcher $dispatcher)
    {

    }

    /**
     * @param Event $event
     * @param Dispatcher $dispatcher
     * @param Exception $exception
     * @return bool
     */
    public function beforeException(Event $event, Dispatcher $dispatcher, Exception $exception)
    {
        $action = 'unavailable';

        if ($exception instanceof DispatchException) {
            $action = 'notFound';
        }
        /**
         * 直接指向基模块的错误处理
         */
        $dispatcher->setNamespaceName("Base\Http\Controllers\\");
        $dispatcher->forward([
            'controller' => 'error',
            'action' => $action,
            'params' => [
                'message' => $exception->getMessage(),
                'data' => [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTraceAsString()
                ]
            ],
        ]);
        return false;
    }
}