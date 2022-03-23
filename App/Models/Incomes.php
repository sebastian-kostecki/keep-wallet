<?php

namespace App\Models;

use PDO;

class Incomes extends \Core\Model
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
        //walidacja danych
        //zapisanie do bazy danych

        $sql = "INSERT INTO incomes 
                VALUES (NULL, :userId, :category, :amount, :date, :comment)";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->bindValue(':category', $this->incomeCategory, PDO::PARAM_INT);
        $query->bindValue(':amount', $this->amount, PDO::PARAM_STR);
        $query->bindValue(':date', $this->date, PDO::PARAM_STR);
        $query->bindValue(':comment', $this->comment, PDO::PARAM_STR);
        return $query->execute();
    }

    public function validate()
    {
        $this->amount = filter_var($this->amount, FILTER_VALIDATE_FLOAT);
        if ((!$this->amount) || ($this->amount < 0) || (strlen(substr(strrchr($this->amount, "."), 1)) > 2)) {
            $this->errors[] = 'Kwota jest nieprawidłowa';
        }

        $dateArr  = explode('/', $this->date);
        if (count($dateArr) == 3) {
            if (!(checkdate($dateArr[0], $dateArr[1], $dateArr[2]))) {
                $this->errors[]  = 'Data jest nieprawidłowa';
            }
        }

        if (!isset($this->incomeCategory)) {
            $this->errors[] = 'Nie wybrano kategorii przychodu';
        }
    }
}
