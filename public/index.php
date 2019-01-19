<?php

use Phalcon\Logger;

$mode = getenv('APP_ENV');

define('CONF_MODE', $mode ? $mode : 'produce');
define('CURRENT_TIMESTAMP', $_SERVER['REQUEST_TIME']);
define('CURRENT_TIME', date('Y-m-d H:i:s', CURRENT_TIMESTAMP));

define("CONF_MODE_LOCAL", "local");
define("CONF_MODE_DEV", "dev");
define("CONF_MODE_BETA", "beta");
define("CONF_MODE_PRODUCE", "produce");

$app = require __DIR__ . '/../bootstrap/bootstrap.php';

try {
    $response = $app->handle();
    if (!PHP_SAPI == "cli") {
        if ($response && !$response->isSent()) {
            $response->send();
        }
    }

} catch (\Exception $e) {

    $logger = $app->get("log.run");
    $logger->log($e->getMessage(), Logger::INFO);
    $logger->log($e->getTraceAsString(), Logger::INFO);

    header("Content-Type:application/json;charset=UTF-8");
    exit(json_encode(['message' => '系统发生错误', 'code' => 505], JSON_UNESCAPED_UNICODE));
}
