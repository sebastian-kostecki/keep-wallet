<?php

namespace App\Models;

use PDO;

class PaymentMethod extends \Core\Model
{
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function findPaymentMethods($user)
    {
        $sql = "SELECT * 
                FROM payment_methods_assigned_to_users 
                WHERE user_id = :userId";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $user->id, PDO::PARAM_INT);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetchAll();
    }
}
