<?php

namespace Core;

use PDO;
use PDOException;
use App\Config;

abstract class Model
{
    protected static function getDataBase()
    {
        static $db = null;

        if ($db === null) {
            try {
                $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';
                $databaseConnection = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);
                $databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $error) {
                echo $error->getMessage();
            }
        }
        return $databaseConnection;
    }
}
