<?php
namespace App;

use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    protected $moduleName = "";

    /**
     * 注册自定义加载器
     */
    public function registerAutoloaders(\Phalcon\DiInterface $di = null)
    {
        $moduleName = $this->moduleName;
        if ($moduleName == false) {
            throw new \Exception("module name can not empty !", 500);
        }

        $path = $di->get('path');
        $moduleBasePath = $path->modules . DIRECTORY_SEPARATOR . ucfirst($moduleName) . DIRECTORY_SEPARATOR;

        $loader = $di->get('autoloader');
        $loader->registerNamespaces(array(

            'Services' => $moduleBasePath . '/Services/',
            'Helpers' => $moduleBasePath . '/Helpers/',
        ));
        $loader->register();
    }

    /**
     * 注册自定义服务
     */
    public function registerServices(\Phalcon\DiInterface $di = null)
    {
        /*

    $path = $this['path'];
    $configName = sprintf("%s.php", CONF_MODE);

    $configPath = $path->modules . DIRECTORY_SEPARATOR . ucfirst($moduleName) . DIRECTORY_SEPARATOR . 'Config/' . $configName;

    if (is_file($configPath)) {
    $data = require $configPath;
    $moduleConfig = new Config($data);

    $config = $di->get("config");
    $config->merge($moduleConfig);
    }
     */
    }
}
