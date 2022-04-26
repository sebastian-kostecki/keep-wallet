<?php

namespace App\Models;

use PDO;

class Incomes extends BudgetItem
{
    protected const NAME_OF_TABLE_WITH_BUDGET_ITEMS = "incomes";

    public function save()
    {
        $this->validate();
        if (empty($this->errors)) {

            $sql = "INSERT INTO incomes 
                    VALUES (NULL, :userId, :category, :amount, :date, :comment)";

            $db = static::getDataBase();
            $query = $db->prepare($sql);
            $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
            $query->bindValue(':category', $this->category, PDO::PARAM_INT);
            $query->bindValue(':amount', $this->amount, PDO::PARAM_STR);
            $query->bindValue(':date', $this->date, PDO::PARAM_STR);
            $query->bindValue(':comment', $this->comment, PDO::PARAM_STR);
            return $query->execute();
        }
        return false;
    }

    public function validate()
    {
        $this->isAmountChosen();
        $this->isAmountValid();
        $this->isDateChosen();
        $this->isDateValid();
        $this->isCategoryChosen();
        $this->isCommentValid();
    }

    public function change()
    {
        $this->validate();
        if (empty($this->errors)) {

            $sql = "UPDATE incomes
                    SET income_category_assigned_to_user_id = :category, amount = :amount, date_of_income = :date, income_comment = :comment
                    WHERE id = :id";

            $db = static::getDataBase();
            $query = $db->prepare($sql);
            $query->bindValue(':id', $this->id, PDO::PARAM_INT);
            $query->bindValue(':category', $this->category, PDO::PARAM_INT);
            $query->bindValue(':amount', $this->amount, PDO::PARAM_STR);
            $query->bindValue(':date', $this->date, PDO::PARAM_STR);
            $query->bindValue(':comment', $this->comment, PDO::PARAM_STR);
            return $query->execute();
        }
        return false;
    }

    public static function getUserIncomesGroupByCategories()
    {
        $sql = "SELECT incomes.user_id, incomes_category_assigned_to_users.name, SUM(incomes.amount) as total
                FROM incomes INNER JOIN incomes_category_assigned_to_users 
                WHERE incomes.user_id = :userId AND incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id AND date_of_income BETWEEN :firstDay AND :lastDay GROUP BY incomes.income_category_assigned_to_user_id ORDER BY total DESC";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->bindValue(':firstDay', self::getfirstDayOfPeriod(), PDO::PARAM_STR);
        $query->bindValue(':lastDay', self::getLastDayOfPeriod(), PDO::PARAM_STR);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetchAll();
    }

    public static function getAllUserIncomes()
    {
        $sql = "SELECT incomes.id, income_user.name, incomes.amount, incomes.date_of_income, incomes.income_comment, incomes.income_category_assigned_to_user_id
                FROM incomes INNER JOIN incomes_category_assigned_to_users as income_user 
                WHERE incomes.user_id = :userId AND incomes.income_category_assigned_to_user_id = income_user.id AND incomes.date_of_income BETWEEN :firstDay AND :lastDay ORDER BY incomes.date_of_income";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->bindValue(':firstDay', self::getfirstDayOfPeriod(), PDO::PARAM_STR);
        $query->bindValue(':lastDay', self::getLastDayOfPeriod(), PDO::PARAM_STR);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetchAll();
    }
}
