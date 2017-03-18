<?php
namespace KAY\Framework\Component\EntityManager;

use PDO;

abstract class EntityQuery
{
    /**
     * @var PDO
     */
    protected $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    protected function execute()
    {
        
    }
}