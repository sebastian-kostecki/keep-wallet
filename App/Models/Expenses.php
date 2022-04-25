<?php

namespace App\Models;

use PDO;

class Expenses extends \Core\Model
{
    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function save()
    {
        $this->validate();

        if (empty($this->errors)) {
            $sql = "INSERT INTO expenses 
                VALUES (NULL, :userId, :category, :payment, :amount, :date, :comment)";

            $db = static::getDataBase();
            $query = $db->prepare($sql);
            $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
            $query->bindValue(':category', $this->category, PDO::PARAM_INT);
            $query->bindValue(':payment', $this->paymentMethod, PDO::PARAM_INT);
            $query->bindValue(':amount', $this->amount, PDO::PARAM_STR);
            $query->bindValue(':date', $this->date, PDO::PARAM_STR);
            $query->bindValue(':comment', $this->comment, PDO::PARAM_STR);

            return $query->execute();
        }
        return false;
    }

    public function validate()
    {
        if (!isset($this->amount)) {
            $this->errors[] = 'Brak kwoty wydatku';
        }

        $this->amount = filter_var($this->amount, FILTER_VALIDATE_FLOAT);
        if ((!$this->amount) || ($this->amount < 0) || (strlen(substr(strrchr($this->amount, "."), 1)) > 2)) {
            $this->errors[] = 'Kwota jest nieprawidłowa';
        }

        if (!isset($this->date)) {
            $this->errors[] = 'Nie wybrano daty wydatku';
        }


        $dateArr  = explode('/', $this->date);
        if (count($dateArr) == 3) {
            if (!(checkdate($dateArr[0], $dateArr[1], $dateArr[2]))) {
                $this->errors[]  = 'Data jest nieprawidłowa';
            }
        }

        if (!isset($this->paymentMethod)) {
            $this->errors[] = 'Nie wybrano sposobu płatności';
        }

        if (!isset($this->category)) {
            $this->errors[] = 'Nie wybrano kategorii wydatku';
        }

        if (strlen($this->comment) > 100) {
            $this->errors[]  = 'Komentarz może zawierać maksymalnie 100 znaków';
        }
    }

    public function change()
    {
        $this->validate();

        if (empty($this->errors)) {

            $sql = "UPDATE expenses
                    SET amount = :amount, date_of_expense = :date, expense_comment = :comment, payment_method_assigned_to_user_id = :paymentMethod, expense_category_assigned_to_user_id = :category
                    WHERE id = :id";

            $db = static::getDataBase();
            $query = $db->prepare($sql);
            $query->bindValue(':id', $this->id, PDO::PARAM_INT);
            $query->bindValue(':category', $this->category, PDO::PARAM_INT);
            $query->bindValue(':amount', $this->amount, PDO::PARAM_STR);
            $query->bindValue(':date', $this->date, PDO::PARAM_STR);
            $query->bindValue(':paymentMethod', $this->paymentMethod, PDO::PARAM_INT);
            $query->bindValue(':comment', $this->comment, PDO::PARAM_STR);
            return $query->execute();
        }
        return false;
    }

    public function remove()
    {
        $sql = "DELETE FROM expenses
                WHERE id = :id";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $query->execute();
    }
}
