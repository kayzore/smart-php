<?php
namespace KAY\Framework\Bundle\ViewBundle;

use KAY\Framework\Component\Kernel;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Chain;
use Twig_Loader_Filesystem;

class TwigRender
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    public function __construct($path, $array, array $vars = array())
    {
        $bundle = $array[0];
        $loader1 = new Twig_Loader_Filesystem('../app/Ressources/Views/');
        $loader2 = new Twig_Loader_Filesystem('../src/' . $bundle . '/Ressources/Views/');

        $loader = new Twig_Loader_Chain(array($loader1, $loader2));
        $this->twig = new Twig_Environment($loader, array(
            'cache' => (Kernel::getDevMode() === true ? false : '../twig_cache/'),
            'debug' => Kernel::getDevMode()
        ));
        $this->twig->addExtension(new Twig_Extension_Debug());

        $this->twig->addExtension(new CoreExtensions());
        if (file_exists('../app/Twig/MyExtensions.php')) {
            $this->twig->addExtension(new \Twig\MyExtensions());
        }
    }

    /**
     * Render View
     * @param $path
     * @param array $vars
     * @return string
     */
    public function renderView($path, array $vars)
    {
        return $this->twig->render($path, $vars);
    }
}