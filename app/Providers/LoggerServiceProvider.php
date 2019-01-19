<?php
/**
 * Created by PhpStorm.
 * User: zhanhong01
 * Date: 2019/1/9
 * Time: 14:49
 */

namespace App\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File;

class LoggerServiceProvider implements ServiceProviderInterface
{
    /**
     * @param \Phalcon\DiInterface $di
     */
    public function register(\Phalcon\DiInterface $di)
    {
        $config = $di->get('config');

        $filename = sprintf($di->get('config')->get('log.run'), $di->get('path')->storage, today());
        $logger = new File($filename);
        $logger->setLogLevel(Logger::INFO);

        $di->set('log.run', $logger, true);

        $filename = sprintf($di->get('config')->get('log.sql'), $di->get('path')->storage, today());
        $logger = new File($filename);
        $logger->setLogLevel(Logger::INFO);

        $di->set('log.sql', $logger, true);

    }
}
