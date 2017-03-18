<?php
namespace KAY\Framework\Component;

use KAY\Framework\Bundle\ExceptionBundle\Controller\DevExceptionController;
use KAY\Framework\Bundle\RouterBundle\Route;
use KAY\Framework\Bundle\RouterBundle\Router;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

abstract class Kernel
{
    protected $bundles = array();
    protected $environment;
    protected $debug;
    /**
     * @var Router
     */
    private $router;
    /**
     * @var array $routes
     */
    private $routes;
    const VERSION = '0.7.0';
    private static $DEV_MODE = false;
    private static $DOC_ROOT = '';

    /**
     * Constructor.
     *
     * @param string $environment The environment
     * @param bool   $debug       Whether to enable debugging or not
     */
    public function __construct($environment, $debug)
    {
        $this->environment = $environment;
        $this->debug = (bool) $debug;
        $this->bundles = $this->registerBundles();
        $this->searchAllRoutes();
        $this->setRouter(new Router($this->routes));
        self::$DEV_MODE = $debug;
        $this->startRouter();

    }
    private function startRouter()
    {
        $route = $this->router->start();
        $parameters = Yaml::parse(file_get_contents('../app/Config/parameters.yml'));
        $config = Yaml::parse(file_get_contents('../app/Config/config.yml'));

        if (!array_key_exists('error', $route) && !array_key_exists('controller', $route)) {
            $route = array(
                'error' => array(
                    'type' => 404,
                    'message' => 'Class ' . $route['controller'] . ' not found'
                )
            );
        }
        if (array_key_exists('error', $route)) {
            $this->startException(
                $parameters['parameters'],
                $config['session'],
                $route['error']
            );
        } else {
            echo $this->startController(
                $parameters['parameters'],
                $config['session'],
                $route
            );
        }
    }
    private function startController($parameters, $config, $route)
    {
        self::$DOC_ROOT = $parameters['project_sub_folder'];
        $controller = new $route['controller'](
            $parameters,
            $this->getRouter(), $config
        );
        return call_user_func_array([$controller, $route['action']], $route['params']);
    }
    private function startException($parameters, $config, $error)
    {
        if (self::$DEV_MODE === true) {
            // DEV Exception
            new DevExceptionController(
                $parameters,
                $this->getRouter(),
                $config,
                $error
            );
        } else {
            // PROD Exception
        }
    }
    public static function getDevMode()
    {
        return self::$DEV_MODE;
    }
    public static function getDocRoot()
    {
        return self::$DOC_ROOT;
    }
    public function getRouter()
    {
        return $this->router;
    }
    public function setRouter($router)
    {
        $this->router = $router;

        return $this;
    }
    public function getBundles()
    {
        return $this->bundles;
    }
    /**
     * Search all routes in project
     */
    private function searchAllRoutes()
    {
        $routes_tmp = [];
        try {
            foreach ($this->bundles as $bundle) {
                if (file_exists($bundle->getPath() . '/Ressources/Config/routing.yml')){
                    $routes_tmp = Yaml::parse(file_get_contents($bundle->getPath() . '/Ressources/Config/routing.yml'));
                }
            }
        } catch (ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
        }
        $routes = [];
        foreach ($routes_tmp as $name => $route) {
            $default = explode(':', $route['default']['_controller']);

            $routes[] = new Route(array(
                'name' => $name,
                'path' => $route['path'],
                'methods' => $route['methods'],
                'bundle' => $default[0],
                'controller' => $default[1] . 'Controller',
                'action' => $default[2] . 'Action'
            ));
        }
        $this->routes = $routes;
    }
    public function getEnvironment()
    {
        return $this->environment;
    }
    public function isDebug()
    {
        return $this->debug;
    }
    public function getCharset()
    {
        return 'UTF-8';
    }
    /**
     * Returns the kernel parameters.
     *
     * @return array An array of kernel parameters
     */
    protected function getKernelParameters()
    {
        $bundles = array();
        $bundlesMetadata = array();
        foreach ($this->bundles as $name => $bundle) {
            $bundles[$name] = get_class($bundle);
            $bundlesMetadata[$name] = array(
                'path' => $bundle->getPath(),
                'namespace' => $bundle->getNamespace(),
            );
        }
        return array_merge(
            array(
                'kernel.environment' => $this->environment,
                'kernel.debug' => $this->debug,
                'kernel.bundles' => $bundles,
                'kernel.bundles_metadata' => $bundlesMetadata,
                'kernel.charset' => $this->getCharset(),
            ),
            $this->getEnvParameters()
        );
    }
    /**
     * Gets the environment parameters.
     *
     * Only the parameters starting with "SYMFONY__" are considered.
     *
     * @return array An array of parameters
     */
    protected function getEnvParameters()
    {
        $parameters = array();
        foreach ($_SERVER as $key => $value) {
            if (0 === strpos($key, 'SYMFONY__')) {
                $parameters[strtolower(str_replace('__', '.', substr($key, 9)))] = $value;
            }
        }
        return $parameters;
    }
    abstract function registerBundles();
}