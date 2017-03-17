<?php
namespace KAY\Framework\Component\Session;


class Session
{
    /**
     * @var array $session
     */
    private $session;

    public function __construct(array $parameters)
    {
        session_start();
        if (isset($_SESSION[strtolower($parameters['project_name'])])) {
            $session = $_SESSION[strtolower($parameters['project_name'])];
        } else {
            $session = array();
        }
        $this->setSession($session);

        return $this->getSession();
    }

    /**
     * @return array
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param array $session
     * @return Session
     */
    public function setSession($session)
    {
        $this->session = $session;

        return $this;
    }

}