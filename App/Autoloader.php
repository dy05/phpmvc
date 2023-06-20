<?php

namespace RBAC\App;

/**
* Class Autoloader
*/
class Autoloader
{
    /**
    * Enregistre notre autoloader
    */
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
    * Inclue le fichier correspondant à notre classe
    * @param string $class
    * Le nom de la classe à charger
    */
    public static function autoload(string $class)
    {
        $class = str_replace('RBAC\\', '../', $class);
        $class = str_replace('\\', '/', $class);
//        $class = str_replace('RBAC\\', '../', $class);
//        $class = str_replace('\\', '/', $class);
        require $class . '.php';
    }
}
