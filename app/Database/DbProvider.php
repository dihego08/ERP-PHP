<?php
namespace App\Database;

use Pdo;

class DbProvider{
    private static $_db;

    public static function get(){
        //echo "string ". __CONFIG__['db']['host'];
        if(!self::$_db) {
            $pdo = new Pdo(
                __CONFIGU__['db']['host'],
                __CONFIGU__['db']['user'],
                __CONFIGU__['db']['password']
            );
    
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

            self::$_db = $pdo;
        }

        return self::$_db;
    }
}
