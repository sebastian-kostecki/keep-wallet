<?php

namespace App\Models;

use PDO;

class IncomeCategory extends \Core\Model
{
    public static function findCategories()
    {
        $sql = "SELECT * 
                FROM incomes_category_assigned_to_users 
                WHERE user_id = :userId";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetchAll();
    }
}
