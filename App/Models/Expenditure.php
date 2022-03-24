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
        $this->validate();

        if (empty($this->errors)) {
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

        if (!isset($this->expenseCategory)) {
            $this->errors[] = 'Nie wybrano kategorii przychodu';
        }

        if (strlen($this->comment) > 100) {
            $this->errors[]  = 'Komentarz może zawierać maksymalnie 100 znaków';
        }
    }

    protected static function fetchExpensesCategory($period)
    {
        $firstDay = substr($period, 0, 10);
        $lastDay = substr($period, 11);

        $sql = "SELECT expenses_category_assigned_to_users.name, SUM(expenses.amount) as total
        FROM expenses INNER JOIN expenses_category_assigned_to_users 
        WHERE expenses.user_id = :userId AND expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id AND date_of_expense BETWEEN :firstDay AND :lastDay GROUP BY expenses.expense_category_assigned_to_user_id";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->bindValue(':firstDay', $firstDay, PDO::PARAM_STR);
        $query->bindValue(':lastDay', $lastDay, PDO::PARAM_STR);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetchAll();
    }

    protected static function fetchAllExpenses($period)
    {
        $firstDay = substr($period, 0, 10);
        $lastDay = substr($period, 11);

        $sql = "SELECT expense_user.name, expenses.amount, expenses.date_of_expense, expenses.expense_comment, pm.name as payment_method 
                FROM expenses_category_assigned_to_users as expense_user INNER JOIN expenses ON expenses.expense_category_assigned_to_user_id = expense_user.id INNER JOIN payment_methods_assigned_to_users as pm ON pm.id = expenses.payment_method_assigned_to_user_id 
                WHERE expenses.user_id = :userId AND date_of_expense BETWEEN :firstDay AND :lastDay ORDER BY expenses.date_of_expense";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->bindValue(':firstDay', $firstDay, PDO::PARAM_STR);
        $query->bindValue(':lastDay', $lastDay, PDO::PARAM_STR);
        $query->execute();

        return $query->fetchAll();
    }

    public static function fetchExpenses($period)
    {
        $expensesByCategory = static::fetchExpensesCategory($period);
        $expensesAll = static::fetchAllExpenses($period);

        foreach ($expensesByCategory as $expenseByCategory) {
            foreach ($expensesAll as $expense) {
                if ($expenseByCategory->name == $expense['name']) {
                    $expenseByCategory->incomes[] = $expense;
                }
            }
        }
        return $expensesByCategory;
    }
}
