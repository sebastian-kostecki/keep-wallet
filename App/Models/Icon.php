<?php

namespace App\Models;

use PDO;

class Icon extends \Core\Model
{
    public static function getIcons()
    {
        $sql = "SELECT * 
                FROM icons";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetchAll();
    }
}
