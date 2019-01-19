<?php
/**
 * Created by PhpStorm.
 * User: zhoutianliang01
 * Date: 2018/9/28
 * Time: 15:11
 */

namespace App\Providers;


use App\Application;
use App\Events\Event;
use App\Listeners\DispatcherListener;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Events\ManagerInterface;

/**
 * Class EventServiceProvider
 * @package App\Providers
 */
class EventServiceProvider implements ServiceProviderInterface
{

    public function register(\Phalcon\DiInterface $di)
    {
        // TODO: Implement register() method.

        /**
         * @var $eventsManager ManagerInterface
         */
        $eventsManager = $di->get('eventsManager');

        /**
         * @var $app Application
         */
        $app = $di->get('app');

        $eventsManager->attach(Event::APPLICATION, $app);

        PHP_SAPI !== 'cli' && $eventsManager->attach(Event::DISPATCHER, new DispatcherListener());

        $dispatcher = $di->get('dispatcher');
        $dispatcher->setEventsManager($eventsManager);
    }
}