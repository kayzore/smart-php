<?php
namespace KAY\Framework\Bundle\ViewBundle;

use KAY\Framework\Bundle\RouterBundle\Route;
use KAY\Framework\Component\Kernel;
use KAY\Framework\Component\Session\User;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

class CoreExtensions extends \Twig_Extension
{
    private $routes;
    /**
     * @var User
     */
    private $user;

    public function __construct($routes, $user)
    {
        $this->routes = $routes;
        $this->user = $user;
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
            new Twig_SimpleFunction('isGranted', array($this, 'isGrantedFunction')),
            new Twig_SimpleFunction('form', array($this, 'formFunction')),
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

    public function formFunction($fields)
    {
        echo '<form method="post">';
        foreach ($fields as $type => $field) {
            if ($type != 'errors') {
                echo '<div class="form-group">';
                echo nl2br($field);
                if (isset($fields['errors']['_' . $type])) {
                    echo '<span class="help-block">' . $fields['errors']['_' . $type] . '</span>';
                }
                echo '</div>';
            }
        }
        echo '</form>';
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

    public function isGrantedFunction(array $roles_user)
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
}