<?php
namespace KAY\Framework\Bundle\RouterBundle;


class Router
{
    /**
     * @var array $routes
     */
    private $routes;
    /**
     * @var string
     */
    private $url;
    private $request_method;

    public function __construct($routes)
    {
        $this->request_method = $_SERVER['REQUEST_METHOD'];
        $this->routes = $routes;
        $this->url = '/' . $_GET['url'];
    }

    public function start()
    {
        return $this->searchRoute();
    }

    /**
     * Recherche une route, vérifie si la methode est accepté par la route
     * TODO: Create 404 not found page
     * TODO: Create Access denied
     * @return array|string
     */
    private function searchRoute()
    {
        $match_route = $this->checkRoute();
        if ($match_route[0]) {
            $request_method = $this->checkMethod($match_route[1]);
            if ($request_method) {
                $action = $match_route[1]->getAction();
                $controller = '\\' . $match_route[1]->getBundle() . '\Controller\\' . $match_route[1]->getController();
                return array(
                    'controller'    => $controller,
                    'action'        => $action,
                    'params'        => $match_route[2]
                );
            } else {
                // ERROR Access via this request method not authorized
                return 'ERROR Access via this request method not authorized';
            }
        } else {
            // ERROR 404 NOT FOUND
            return 'ERROR 404 NOT FOUND';
        }
    }

    private function checkRoute()
    {
        $match_route = array(false, '');
        foreach ($this->routes as $route) {
            $params = $route->match($this->url);
            if (!$params) {
                $params = $route->match($this->url . '/');
            }
            if (!$params) {
                if ($route->getPath() === '/' . $_GET['url'] || $route->getPath() === '/' . $_GET['url'] . '/') {
                    $params = array();
                }
            }
            if (is_array($params)){
                $match_route[0] = true;
                $match_route[1] = $route;
                array_push($match_route, $params);
                break;
            }
        }
        return $match_route;
    }

    /**
     * Check si la method est accepté par la route
     * @param Route $route
     * @return bool
     */
    private function checkMethod($route)
    {
        $request_method = false;
        foreach ($route->getMethods() as $method) {
            if ($method === $_SERVER['REQUEST_METHOD']) {
                $request_method = true;
                break;
            }
        }
        return $request_method;
    }
}