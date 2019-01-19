<?php
/**
 * Created by PhpStorm.
 * User: zhoutianliang01
 * Date: 2018/9/28
 * Time: 15:35
 */

namespace App\Providers;

use App\Models\Manager;
use PDO;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Db\Profiler as DbProfiler;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Mvc\Model\MetaData\Files;
use Phalcon\Mvc\Model\MetaData\Memory;

class DatabaseServiceProvider implements ServiceProviderInterface
{

    public function register(\Phalcon\DiInterface $di)
    {
        // TODO: Implement register() method.

        $config = $di->get("config");

        $options = $this->getDefaultOptions();

        foreach ($config->database as $name => $dbConfig) {
            $source = 'db.' . $name;
            $connection = new Mysql((array) $dbConfig);
            if (CONF_MODE == 'local') {
                $eventsManager = new \Phalcon\Events\Manager();
                // 分析底层sql性能，并记录日志
                $profiler = new DbProfiler();
                $logger = $di->get("log.sql");

                $eventsManager->attach('db', function ($event, $connection) use ($profiler, $logger) {
                    if ($event->getType() == 'beforeQuery') {
                        //在sql发送到数据库前启动分析
                        $profiler->startProfile($connection->getSQLStatement());
                    }
                    if ($event->getType() == 'afterQuery') {
                        //在sql执行完毕后停止分析
                        $profiler->stopProfile();
                        //获取分析结果
                        $profile = $profiler->getLastProfile();
                        $sql = $profile->getSQLStatement();
                        $executeTime = $profile->getTotalElapsedSeconds();
                        //日志记录
                        $message = ("{$sql} {$executeTime}");
                        $logger->log($message);
                    }
                });
                $connection->setEventsManager($eventsManager);
            }
            $di->set($source, $connection, true);
        }

        $di->set('modelsMetadata', function () {
            if (CONF_MODE != 'product') {
                return new Memory();
            }
            return new Files([
                'metaDataDir' => $this['path']->storage . '/caches/',
            ]);
        }, true);

        $di->set('modelsCache', function () {
            $frontData = new Data([
                'lifetime' => 86400,
            ]);
            return new Redis($frontData, [
                'prefix' => 'mc_',
                'redis' => $this->get('redis.cache'),
            ]);
        }, true);

        $di->set('modelsManager', function () {
            return new Manager();
        }, true);
    }

    /**
     * @return array
     */
    public function getDefaultOptions()
    {
        return [
            PDO::ATTR_CASE => PDO::CASE_NATURAL,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
            PDO::ATTR_STRINGIFY_FETCHES => false,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
    }
}
