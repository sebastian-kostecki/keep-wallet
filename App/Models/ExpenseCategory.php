<?php

namespace App\Models;

use PDO;

class ExpenseCategory extends BudgetCategory
{
    protected const NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS = "expenses_category_assigned_to_users";

    public static function findCategories()
    {
        $sql = "SELECT * 
                FROM expenses_category_assigned_to_users NATURAL JOIN icons
                WHERE expenses_category_assigned_to_users.user_id = :userId";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetchAll();
    }

    protected static function assignDeletedCategoriesExpensesToOtherExpenses($categoryId)
    {
        $sql = 'UPDATE expenses
                SET expense_category_assigned_to_user_id = (SELECT id FROM expenses_category_assigned_to_users WHERE name = "Inne przychody" AND user_id = :userId)
                WHERE expense_category_assigned_to_user_id = :idDeletedCategory';

        $db = static::getDataBase();
        $query = $db->prepare($sql);

        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->bindValue(':idDeletedCategory', $categoryId, PDO::PARAM_INT);
        return $query->execute();
    }

    public static function remove($categoriesToDelete)
    {
        foreach ($categoriesToDelete as $categoryToDelete) {
            if (static::assignDeletedCategoriesExpensesToOtherExpenses($categoryToDelete)) {
                $sql = 'DELETE FROM expenses_category_assigned_to_users 
                        WHERE id = :idCategory';

                $db = static::getDataBase();
                $query = $db->prepare($sql);

                $query->bindValue(':idCategory', $categoryToDelete, PDO::PARAM_INT);
                if ($query->execute() == false) {
                    return false;
                }
            } else {
                return false;
            }
        }
        return true;
    }
}
