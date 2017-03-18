<?php
namespace KAY\Framework\Component;

use KAY\Framework\Component\EntityManager\EntityManager;

class Container
{
    /**
     * @var array
     */
    protected $parameters;

    protected function get($fonctionality)
    {
        $fonctionality_and_db = explode(':', $fonctionality);
        switch (strtolower($fonctionality_and_db[0])) {
            case 'entitymanager':
                return new EntityManager($fonctionality_and_db[1], $this->parameters);
                break;
            default:
                return '404';
                break;
        }
    }
}