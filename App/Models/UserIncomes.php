<?php

namespace App\Models;

use PDO;

class UserIncomes extends \Core\Model
{
    public static function getUserIncomesGroupByCategories($period)
    {
        $firstDay = substr($period, 0, 10);
        $lastDay = substr($period, 11);

        $sql = "SELECT incomes.user_id, incomes_category_assigned_to_users.name, SUM(incomes.amount) as total
                FROM incomes INNER JOIN incomes_category_assigned_to_users 
                WHERE incomes.user_id = :userId AND incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id AND date_of_income BETWEEN :firstDay AND :lastDay GROUP BY incomes.income_category_assigned_to_user_id ORDER BY total DESC";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->bindValue(':firstDay', $firstDay, PDO::PARAM_STR);
        $query->bindValue(':lastDay', $lastDay, PDO::PARAM_STR);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetchAll();
    }

    public static function getAllUserIncomes($period)
    {
        $firstDay = substr($period, 0, 10);
        $lastDay = substr($period, 11);

        $sql = "SELECT income_user.name, incomes.amount, incomes.date_of_income, incomes.income_comment 
                FROM incomes INNER JOIN incomes_category_assigned_to_users as income_user 
                WHERE incomes.user_id = :userId AND incomes.income_category_assigned_to_user_id = income_user.id AND incomes.date_of_income BETWEEN :firstDay AND :lastDay ORDER BY incomes.date_of_income";

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
