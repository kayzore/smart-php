<?php
namespace KAY\Framework\Component\Session;


class User
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $username_slug;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $password;
    /**
     * @var array
     */
    private $roles;
    /**
     * @var \DateTime
     */
    private $register_date;

    public function __construct(array $user = null)
    {
        if (!is_null($user)) {
            if (isset($user['id'])) {
                $this->setId($user['id']);
            }
            if (isset($user['username'])) {
                $this->setUsername($user['username']);
            }
            if (isset($user['email'])) {
                $this->setEmail($user['email']);
            }
            if (isset($user['password'])) {
                $this->setPassword($user['password']);
            }
            if (isset($user['roles'])) {
                $this->setRoles($user['roles']);
            } else {
                $this->setRoles(array('ROLE_USER'));
            }
            if (isset($user['register_date'])) {
                $this->setRegisterDate($user['register_date']);
            }
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param int $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    /**
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }
    /**
     * @return string
     */
    public function getUsernameSlug()
    {
        return $this->username_slug;
    }
    /**
     * @param string $usernameSlug
     * @return User
     */
    public function setUsernameSlug($usernameSlug)
    {
        $this->username_slug = $usernameSlug;

        return $this;
    }
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }
    /**
     * @param array $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }
    /**
     * @return \DateTime
     */
    public function getRegisterDate()
    {
        return $this->register_date;
    }
    /**
     * @param \DateTime $register_date
     */
    public function setRegisterDate($register_date)
    {
        $this->register_date = $register_date;
    }
}