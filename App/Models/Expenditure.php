<?php

namespace App\Models;

use PDO;

class Expenditure extends \Core\Model
{
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function save()
    {
        $sql = "INSERT INTO expenses 
                VALUES (NULL, :userId, :category, :payment, :amount, :date, :comment)";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->bindValue(':category', $this->expenseCategory, PDO::PARAM_INT);
        $query->bindValue(':payment', $this->paymentMethod, PDO::PARAM_INT);
        $query->bindValue(':amount', $this->amount, PDO::PARAM_STR);
        $query->bindValue(':date', $this->date, PDO::PARAM_STR);
        $query->bindValue(':comment', $this->comment, PDO::PARAM_STR);

        return $query->execute();
    }
}
