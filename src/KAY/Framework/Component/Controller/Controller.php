<?php
namespace KAY\Framework\Component\Controller;

use KAY\Framework\Bundle\FormBundle\FormBuilder;
use KAY\Framework\Bundle\FormBundle\FormTypeInterface;
use KAY\Framework\Bundle\RouterBundle\Route;
use KAY\Framework\Bundle\RouterBundle\Router;
use KAY\Framework\Bundle\ViewBundle\TwigRender;
use KAY\Framework\Component\Container;
use KAY\Framework\Component\Kernel;
use KAY\Framework\Component\Session\Session;
use KAY\Framework\Component\Session\User;

class Controller extends Container
{
    /**
     * @var Session Session
     */
    private $session;
    /**
     * @var Router
     */
    private $router;
    /**
     * @var User
     */
    private $user;
    /**
     * @var array
     */
    private $post;

    public function __construct(array $parameters, Router $router, $session_config)
    {
        if (isset($_POST)) {
            $this->post = $_POST;
        }
        $this->parameters = $parameters;
        $this->session = new Session($this->parameters);
        $this->router = $router;
        if ($session_config['use_framework']) {
            $this->user = new $session_config['user_entity']();
        }
    }

    /**
     * Retourne une vue au kernel
     * @param string $path
     * @param array $vars
     * @return string The view
     */
    protected function render($path, array $vars = array())
    {
        $array = explode('::', $path);
        $twig =  new TwigRender($path, $array, $vars);
        $path = str_replace(':', '/', $array[1]);
        return $twig->renderView($path, $vars);
    }
    /**
     * @param FormTypeInterface $formType
     * @return mixed
     */
    protected function buildForm(FormTypeInterface $formType)
    {
        return $formType->buildForm(new FormBuilder());
    }
    /**
     * @param string $route_name Route name
     * @param array $params Route param
     */
    protected function redirect($route_name, array $params = array())
    {
        foreach ($this->router->getRoutes() as $route) {
            if ($route->getName() == $route_name) {
                $matched_route = Route::replaceParams($route->getPath(), $params);
                break;
            }
        }
        if (isset($matched_route)) {
            header('location: /' . $this->parameters['project_sub_folder'] . $matched_route);
            die;
        }
    }
    /**
     * @param string $route_name
     * @param array $params
     * @return string
     */
    protected function generateUrl($route_name, array $params = array())
    {
        foreach ($this->router->getRoutes() as $route) {
            if ($route->getName() == $route_name) {
                $matched_route = Route::replaceParams($route->getPath(), $params);
                break;
            }
        }
        if (isset($matched_route)) {
            return '/' . $this->parameters['project_sub_folder'] . $matched_route;
        }
    }

    /**
     * @param array $roles_user
     * @return bool
     */
    protected function isGranted(array $roles_user)
    {
        if (!is_null($this->user->getRoles())) {
            foreach ($roles_user as $role) {
                if (in_array($role, $this->user->getRoles())) {
                    return true;
                    break;
                }
            }
        }

        return false;
    }

    /**
     * Check si la requête HTTP est une requête ajax
     * @return bool
     */
    protected function isXmlHttpRequest() {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) ? true : false);
    }
    /**
     * @return User
     */
    protected function getUser()
    {
        return $this->user;
    }
    /**
     * @return Session
     */
    protected function getSession()
    {
        return $this->session;
    }
    protected function getPost()
    {
        return $this->post;
    }
}