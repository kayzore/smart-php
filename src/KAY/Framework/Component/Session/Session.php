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
        $session_name = str_replace(' ', '-', strtolower($parameters['project_name']));
        if (isset($_SESSION[$session_name])) {
            $session = $_SESSION[$session_name];
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