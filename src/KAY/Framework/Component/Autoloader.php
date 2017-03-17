<?php
namespace KAY\Framework\Component;


class Autoloader
{
    /**
     * Enregistre l'autoloader
     */
    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * @param $classname string Le nom de la classe à charger
     */
    static function autoload($classname){
        $file = __DIR__ . '/' . str_replace('app\\', '', $classname) . '.php';
        if (!file_exists($file)) {
            $file = '../app/' . str_replace('\\', '/', $classname) . '.php';
        }
        if (!file_exists($file)) {
            $file = '../src/' . str_replace('\\', '/', $classname) . '.php';
        }
        if (file_exists($file)) {
            include_once $file;
        }
    }
}