<?php

namespace App\Models;

use PDO;

class IncomeCategory extends BudgetCategory
{
    protected const NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS = "incomes_category_assigned_to_users";

    public static function findCategories()
    {
        $sql = "SELECT * 
                FROM incomes_category_assigned_to_users NATURAL JOIN icons
                WHERE incomes_category_assigned_to_users.user_id = :userId";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetchAll();
    }

    public function change()
    {
        $this->validate();

        if (empty($this->errors)) {

            $sql = 'UPDATE incomes_category_assigned_to_users 
                    SET name = :nameCategory, icon_id = (SELECT icon_id FROM icons WHERE icon = :nameIcon)
                    WHERE id = :idOldCategory';

            $db = static::getDataBase();
            $query = $db->prepare($sql);

            $query->bindValue(':nameCategory', $this->name, PDO::PARAM_STR);
            $query->bindValue(':nameIcon', $this->icon, PDO::PARAM_STR);
            $query->bindValue(':idOldCategory', $this->oldCategory, PDO::PARAM_INT);
            return $query->execute();
        }
        return false;
    }

    protected static function assignDeletedCategoriesIncomesToOtherIncomes($categoryId)
    {
        $sql = 'UPDATE incomes
                SET income_category_assigned_to_user_id = (SELECT id FROM incomes_category_assigned_to_users WHERE name = "Inne przychody" AND user_id = :userId)
                WHERE income_category_assigned_to_user_id = :idDeletedCategory';

        $db = static::getDataBase();
        $query = $db->prepare($sql);

        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->bindValue(':idDeletedCategory', $categoryId, PDO::PARAM_INT);
        return $query->execute();
    }

    public static function remove($categoriesToDelete)
    {
        foreach ($categoriesToDelete as $categoryToDelete) {
            if (static::assignDeletedCategoriesIncomesToOtherIncomes($categoryToDelete)) {
                $sql = 'DELETE FROM incomes_category_assigned_to_users 
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
