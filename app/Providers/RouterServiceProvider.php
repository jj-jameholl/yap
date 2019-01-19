<?php
/**
 * Created by PhpStorm.
 * User: zhanhong01
 * Date: 2019/1/9
 * Time: 15:02
 */

namespace App\Providers;

use Phalcon\Annotations\Factory;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Mvc\Router\Annotations;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class RouterServiceProvider implements ServiceProviderInterface
{

    public function register(\Phalcon\DiInterface $di)
    {

        $path = $di->get('path');

        $di->set('annotations', function () use ($path) {
            return Factory::load([
                'prefix' => 'annotations',
                'adapter' => CONF_MODE === CONF_MODE_PRODUCE ? 'files' : 'memory',
                'annotationsDir' => $path->storage . '/caches/',
            ]);
        }, true);

        $controllers = $this->getMappingResource($path->modules, $path->storage, $path->app);
        $di->set('router', function () use ($controllers) {
            $router = new Annotations(false);
            $router->setDI($this);

            $annotations = $this->get('annotations');

            foreach ($controllers as $controller) {
                $reflection = $annotations->get($controller . 'Controller');
                $collection = $reflection->getClassAnnotations();
                if (!$collection || !$collection->has('RoutePrefix') || !$collection->has('Module')) {
                    continue;
                }

                $prefix = $collection->get("RoutePrefix");
                $moduleName = $collection->get("Module")->getArgument(0);

                $collections = $annotations->getMethods($controller . 'Controller');
                foreach ($collections as $collection) {
                    if ($collection->has('Route')) {
                        $r = $collection->get('Route')->getArgument(0);
                        $router->addModuleResource($moduleName, $controller, $prefix->getArgument(0) . $r);
                    }
                }
            }
            return $router;
        }, true);
    }

    /**
     * @param string $modulePath
     * @param string $storagePath
     * @param string $appPath
     * @return array|mixed
     */
    protected function getMappingResource(string $modulePath, string $storagePath, string $appPath)
    {
        $cacheFile = $storagePath . '/caches/controller.cache.php';
        if (CONF_MODE === CONF_MODE_PRODUCE) {
            if (file_exists($cacheFile)) {
                return require $cacheFile;
            }
        }
        $controllers = [];
        $objects = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($modulePath),
            RecursiveIteratorIterator::SELF_FIRST
        );
        /** @var TYPE_NAME $splInfo */
        foreach ($objects as $name => $splInfo) {
            /**
             * @var $splInfo SplFileInfo
             */
            if ($splInfo->isFile()
                && $splInfo->getExtension() == 'php'
                && $splInfo->getFilename() != 'Controller.php'
                && strpos($splInfo->getPath(), 'Http' . DIRECTORY_SEPARATOR . 'Controllers')
            ) {
                $controllers[] = ucfirst(str_replace(
                    [$modulePath . DIRECTORY_SEPARATOR, 'Controller.php', DIRECTORY_SEPARATOR],
                    ['', '', '\\'],
                    $name
                ));
            }
        }

        if ($controllers) {
            file_put_contents($cacheFile, "<?php\nreturn " . var_export($controllers, true) . ";\n?>");
        }
        return $controllers;
    }
}
