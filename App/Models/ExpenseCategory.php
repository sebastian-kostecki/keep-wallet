<?php

namespace App\Models;

use PDO;

class ExpenseCategory extends BudgetCategory
{
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

    public function save()
    {
        if (empty($this->errors)) {
            $sql = "INSERT INTO expenses_category_assigned_to_users
                    VALUES (NULL, :userId, :nameCategory, (SELECT icon_id FROM icons WHERE icon = :nameIcon))";

            $db = static::getDataBase();
            $query = $db->prepare($sql);
            $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
            $query->bindValue(':nameCategory', $this->nameCategory, PDO::PARAM_STR);
            $query->bindValue(':nameIcon', $this->icon, PDO::PARAM_STR);
            return $query->execute();
        }
        return false;
    }

    public function change()
    {
        $this->validate();

        if (empty($this->errors)) {

            $sql = 'UPDATE expenses_category_assigned_to_users 
                    SET name = :nameCategory, icon_id = (SELECT icon_id FROM icons WHERE icon = :nameIcon)
                    WHERE id = :idOldCategory';

            $db = static::getDataBase();
            $query = $db->prepare($sql);

            $query->bindValue(':nameCategory', $this->nameCategory, PDO::PARAM_STR);
            $query->bindValue(':nameIcon', $this->icon, PDO::PARAM_STR);
            $query->bindValue(':idOldCategory', $this->oldCategory, PDO::PARAM_INT);
            return $query->execute();
        }
        return false;
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
