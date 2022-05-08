<?php

namespace App\Models;

use PDO;

class Expenses extends BudgetItem
{
    protected const NAME_OF_TABLE_WITH_BUDGET_ITEMS = "expenses";

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
        $this->isAmountChosen();
        $this->isAmountValid();
        $this->isDateChosen();
        $this->isDateValid();
        $this->isPaymentMethodChosen();
        $this->isCategoryChosen();
        $this->isCommentValid();
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

    public static function getUserExpensesGroupByCategories()
    {
        $sql = "SELECT expenses_category_assigned_to_users.name, SUM(expenses.amount) as total
        FROM expenses INNER JOIN expenses_category_assigned_to_users 
        WHERE expenses.user_id = :userId AND expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id AND date_of_expense BETWEEN :firstDay AND :lastDay GROUP BY expenses.expense_category_assigned_to_user_id ORDER BY total DESC";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->bindValue(':firstDay', self::getfirstDayOfPeriod(), PDO::PARAM_STR);
        $query->bindValue(':lastDay', self::getLastDayOfPeriod(), PDO::PARAM_STR);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetchAll();
    }

    public static function getAllUserExpenses()
    {
        $sql = "SELECT expenses.id, expense_user.name, expenses.amount, expenses.date_of_expense, expenses.expense_comment, pm.name as payment_method, expenses.expense_category_assigned_to_user_id, expenses.payment_method_assigned_to_user_id 
                FROM expenses_category_assigned_to_users as expense_user INNER JOIN expenses ON expenses.expense_category_assigned_to_user_id = expense_user.id INNER JOIN payment_methods_assigned_to_users as pm ON pm.id = expenses.payment_method_assigned_to_user_id 
                WHERE expenses.user_id = :userId AND date_of_expense BETWEEN :firstDay AND :lastDay ORDER BY expenses.date_of_expense";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->bindValue(':firstDay', self::getfirstDayOfPeriod(), PDO::PARAM_STR);
        $query->bindValue(':lastDay', self::getLastDayOfPeriod(), PDO::PARAM_STR);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetchAll();
    }

    public static function getSum($categoryId)
    {
        $sql = "SELECT SUM(amount) as sum
                FROM expenses
                WHERE expense_category_assigned_to_user_id = :categoryId AND date_of_expense BETWEEN :firstDay AND :lastDay";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $query->bindValue(':firstDay', self::getfirstDayOfPeriod(), PDO::PARAM_STR);
        $query->bindValue(':lastDay', self::getLastDayOfPeriod(), PDO::PARAM_STR);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_ASSOC);
        return $query->fetch();
    }
}
