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
}
