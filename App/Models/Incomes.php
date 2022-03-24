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
        $this->validate();
        if (empty($this->errors)) {

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
        return false;
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

        if (strlen($this->comment) > 100) {
            $this->errors[]  = 'Komentarz może zawierać maksymalnie 100 znaków';
        }
    }

    public static function fetchIncomesCategory($user, $period)
    {
        $firstDay = substr($period, 0, 10);
        $lastDay = substr($period, 11);

        $sql = "SELECT incomes_category_assigned_to_users.name, SUM(incomes.amount) as total
                FROM incomes INNER JOIN incomes_category_assigned_to_users 
                WHERE incomes.user_id = :userId AND incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id AND date_of_income BETWEEN :firstDay AND :lastDay GROUP BY incomes.income_category_assigned_to_user_id";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $user->id, PDO::PARAM_INT);
        $query->bindValue(':firstDay', $firstDay, PDO::PARAM_STR);
        $query->bindValue(':lastDay', $lastDay, PDO::PARAM_STR);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetchAll();
    }
}
