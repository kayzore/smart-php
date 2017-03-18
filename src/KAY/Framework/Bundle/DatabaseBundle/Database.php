<?php
namespace KAY\Framework\Bundle\DatabaseBundle;

use PDO;

class Database
{
    /**
     * @var string $db_host
     */
    private static $db_host = '';
    /**
     * @var string $db_name
     */
    private static $db_name = '';
    /**
     * @var string $db_user
     */
    private static $db_user = '';
    /**
     * @var string $db_password
     */
    private static $db_password = '';
    /**
     * @var PDO $instance
     */
    private static $instance;
    /**
     * @var array $db_options
     */
    private static $db_options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    private function __construct() {}

    public static function getDatabase(array $db_configuration)
    {
        if (!array_key_exists('DB_TYPE', $db_configuration)) {
            self::$db_host = $db_configuration['DB_HOST'];
            self::$db_name = $db_configuration['DB_NAME'];
            self::$db_user = $db_configuration['DB_USER'];
            self::$db_password = $db_configuration['DB_PASS'];
            return self::getMysql();
        }
    }

    /**
     * @return string
     */
    private static function getDbHost()
    {
        return self::$db_host;
    }

    /**
     * @return string
     */
    private static function getDbUser()
    {
        return self::$db_user;
    }

    /**
     * @return string
     */
    private static function getDbPassword()
    {
        return self::$db_password;
    }

    /**
     * @return string
     */
    private static function getDbName()
    {
        return self::$db_name;
    }

    /**
     * @return array
     */
    private static function getDbOptions()
    {
        return self::$db_options;
    }

    /**
     * Crée une instance de PDO si elle n'existe pas déjà
     * @return PDO
     */
    private static function getMysql()
    {
        if (is_null(self::$instance)) {
            self::$instance = new  PDO(
                'mysql:dbname=' . self::getDbName() . ';' .
                'host=' . self::getDbHost(),
                self::getDbUser(),
                self::getDbPassword(),
                self::getDbOptions()
            );
        }
        return self::$instance;
    }
}