<?php
namespace KAY\Framework\Bundle\ViewBundle;

use KAY\Framework\Bundle\RouterBundle\Route;
use KAY\Framework\Component\Kernel;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

class CoreExtensions extends \Twig_Extension
{
    private $routes;

    public function __construct($routes)
    {
        var_dump($routes);
        $this->routes = $routes;
    }

    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('truncate', array($this, 'truncateFilter'))
        );
    }

    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('form_widget', array($this, 'formWidgetFunction')),
            new Twig_SimpleFunction('asset', array($this, 'assetFunction')),
            new Twig_SimpleFunction('path', array($this, 'pathFunction')),
        );
    }

    public function getGlobals()
    {
        return array(
            'debug_mode'    => Kernel::getDevMode(),
            'app'           => array(
                //'user'  => $_SESSION['ls_utilisateur']
            )
        );
    }

    public function truncateFilter($string, $limit, $point = true)
    {
        if (strlen($string) > $limit) {
            return substr($string, 0, $limit - 3) . ($point === true ? '...' : '');
        } else {
            return $string;
        }
    }

    public function formWidgetFunction($field)
    {
        echo nl2br($field);
    }

    public function assetFunction($path)
    {
        return '/' . Kernel::getDocRoot() . '/web/' . $path;
    }

    public function pathFunction($route_name, array $params = array())
    {
        $matched_route = '#';
        foreach ($this->routes as $route) {
            if ($route->getName() == $route_name) {
                $matched_route = Route::replaceParams($route->getPath(), $params);
                break;
            }
        }
        return '/' . Kernel::getDocRoot() . $matched_route;
    }
}