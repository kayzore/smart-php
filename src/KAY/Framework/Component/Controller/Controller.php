<?php
namespace KAY\Framework\Component\Controller;

use KAY\Framework\Bundle\FormBundle\FormBuilder;
use KAY\Framework\Bundle\FormBundle\FormTypeInterface;
use KAY\Framework\Bundle\RouterBundle\Router;
use KAY\Framework\Bundle\ViewBundle\TwigRender;
use KAY\Framework\Component\Container;
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

    public function __construct(array $parameters, Router $router, $session_config)
    {
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
     * TODO: Créer la redirection
     * @param string $route_name Route name
     */
    protected function redirect($route_name){}
    /**
     * TODO: Génere une route et la retourne
     * @param string $route_name
     * @param array $vars
     */
    protected function generateUrl($route_name, array $vars)
    {
        // Parcours la liste des routes
        // Si le nom de la route correspond a $_GET['url']
        // Alors on remplace les parametres Router::replaceParams('', array());
    }
    /**
     * TODO: Recherche si l'utilisateur à le role $role
     * @param array $role
     */
    protected function isGranted($role){}

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
}