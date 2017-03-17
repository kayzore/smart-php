<?php
namespace KAY\Framework\Bundle\RouterBundle;


class Route
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $path;
    /**
     * @var array
     */
    private $methods;
    /**
     * @var string
     */
    private $bundle;
    /**
     * @var string
     */
    private $controller;
    /**
     * @var string
     */
    private $action;
    /**
     * @var array
     */
    private $matches = [];
    /**
     * @var array
     */
    private $params = [];

    public function __construct(array $route)
    {
        $this->setName($route['name']);
        $this->setPath($route['path']);
        if (isset($route['methods'])) {
            $this->setMethods($route['methods']);
        } else {
            $this->setMethods(array('GET', 'POST'));
        }
        $this->setBundle($route['bundle']);
        $this->setController($route['controller']);
        $this->setAction($route['action']);
    }

    /**
     * Permet de capturer l'url avec les paramètres
     * get('/posts/:slug-:id') par exemple
     *
     * @param $url
     * @return bool|array
     *
     */
    public function match($url){
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return $this->matches;
    }

    private function paramMatch($match){
        if(isset($this->params[$match[1]])){
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    /**
     * Remplace les paramètres d'une url
     * @param $path string Route (brut)
     * @param $params array Contient les paramètres de la route
     * @return string Url complète
     */
    public static function replaceParams($path, array $params){
        foreach($params as $k => $v){
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param array $methods
     */
    public function setMethods($methods)
    {
        $this->methods = $methods;
    }

    /**
     * @return string
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * @param string $bundle
     */
    public function setBundle($bundle)
    {
        $this->bundle = $bundle;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }
}