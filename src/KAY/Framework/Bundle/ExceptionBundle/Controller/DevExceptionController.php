<?php
namespace KAY\Framework\Bundle\ExceptionBundle\Controller;

use Exception;
use KAY\Framework\Bundle\RouterBundle\Router;
use KAY\Framework\Component\Controller\Controller;

class DevExceptionController extends Controller
{
    public function __construct(array $parameters, Router $router, $session_config, $error)
    {
        parent::__construct($parameters, $router, $session_config);

        switch ($error['type']) {
            case 404:
                $this->exception_404($error);
                break;
            case 500:
                $this->exception_500($error);
                break;
        }
    }

    public function exception_404($error) {
        $title = '404 Not Found';
        $message =  '<h1>' . $error['message'] . '</h1>';

        echo $this->render('ExceptionBundle::content:404.html.twig', array(
            'title'     => $title,
            'message'   => $message
        ));
    }

    public function exception_500($error) {
        $title = '500 Internal Error';
        $message =  '<h1>' . $error['message'] . '</h1>';

        echo $this->render('ExceptionBundle::content:500.html.twig', array(
            'title'     => $title,
            'message'   => $message
        ));
    }
}