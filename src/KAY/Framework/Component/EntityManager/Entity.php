<?php
namespace KAY\Framework\Component\EntityManager;


use KAY\Framework\Bundle\DatabaseBundle\Database;

abstract class Entity
{
    protected $entity;
    protected $entityQuery;
    protected $dbName;
    protected $parameters;

    public function __construct($db_name, $parameters)
    {
        $this->dbName       = $db_name;
        $this->parameters   = $parameters;
    }

    protected function getDatabase()
    {
        if (array_key_exists('database', $this->parameters)) {
            if (array_key_exists($this->dbName, $this->parameters['database'])) {
                return Database::getDatabase(
                    $this->parameters['database'][$this->dbName]
                );
            } else {
                var_dump('database not exist');
            }
        }
        var_dump('database configuration not exist');
    }

    public function findAll()
    {
        $class = get_class($this->entity);
        $className_tmp = explode('\\' ,$class);
        $className = strtolower($className_tmp[count($className_tmp) - 1]);
        $db = $this->getDatabase();
        $stmt = $db->query('SELECT * FROM ' . $className);
        return $stmt->fetchAll(\PDO::FETCH_CLASS, $class);
    }

    public function findById($id)
    {
        $class = get_class($this->entity);
        $className_tmp = explode('\\' ,$class);
        $className = strtolower($className_tmp[count($className_tmp) - 1]);
        $db = $this->getDatabase();
        $stmt = $db->prepare('SELECT * FROM ' . $className . ' WHERE id = :id');
        $stmt->bindParam('id', $id, \PDO::PARAM_INT);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, $class);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function query($query_name, array $params = array())
    {
        if (!empty($params)) {
            return $this->entityQuery->$query_name($params);
        }
        return $this->entityQuery->$query_name();
    }
}