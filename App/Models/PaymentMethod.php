<?php

namespace App\Models;

use PDO;

class PaymentMethod extends \Core\Model
{
    public static function findPaymentMethods()
    {
        $sql = "SELECT * 
                FROM payment_methods_assigned_to_users NATURAL JOIN icons
                WHERE payment_methods_assigned_to_users.user_id = :userId";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetchAll();
    }
}
