<?php

namespace App\Models;

use PDO;

class IncomeCategory extends BudgetCategory
{
    protected const NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS = "incomes_category_assigned_to_users";

    public static function assignContentOfDeletedCategoryToOthers($deletedCategory)
    {
        $sql = 'UPDATE incomes
                SET income_category_assigned_to_user_id = (SELECT id FROM incomes_category_assigned_to_users WHERE name = "Inne przychody" AND user_id = :userId)
                WHERE income_category_assigned_to_user_id = :idDeletedCategory';

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->bindValue(':idDeletedCategory', $deletedCategory, PDO::PARAM_INT);
        $query->execute();
    }
}
