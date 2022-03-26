<?php

namespace App\Models;

use PDO;

class UserExpenses extends \Core\Model
{
    public static function getUserExpensesGroupByCategories($period)
    {
        $firstDay = substr($period, 0, 10);
        $lastDay = substr($period, 11);

        $sql = "SELECT expenses_category_assigned_to_users.name, SUM(expenses.amount) as total
        FROM expenses INNER JOIN expenses_category_assigned_to_users 
        WHERE expenses.user_id = :userId AND expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id AND date_of_expense BETWEEN :firstDay AND :lastDay GROUP BY expenses.expense_category_assigned_to_user_id ORDER BY total DESC";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->bindValue(':firstDay', $firstDay, PDO::PARAM_STR);
        $query->bindValue(':lastDay', $lastDay, PDO::PARAM_STR);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetchAll();
    }

    public static function getAllUserExpenses($period)
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

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetchAll();
    }
}
