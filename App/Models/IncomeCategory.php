<?php

namespace App\Models;

use PDO;

class IncomeCategory extends BudgetCategory
{
    protected const NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS = "incomes_category_assigned_to_users";
    protected const NAME_COLUMN_WITH_BUDGET_ITEMS_ASSIGNED_TO_USER_ID = "income_category_assigned_to_user_id";
    protected const NAME_TABLE_WITH_BUDGET_ITEMS = "incomes";
    protected const NAME_CATEGORY_WITH_ASSIGNED_BUDGET_ITEMS_AFTER_REMOVED_CATEGORY = "Inne przychody";

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
}
