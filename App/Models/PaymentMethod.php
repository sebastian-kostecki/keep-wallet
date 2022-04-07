<?php

namespace App\Models;

use PDO;

class PaymentMethod extends BudgetCategory
{
    protected const NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS = "payment_methods_assigned_to_users";

    public static function assignContentOfDeletedCategoryToOthers($deletedCategory)
    {
        $sql = 'UPDATE expenses
                SET payment_method_assigned_to_user_id = (SELECT id FROM payment_methods_assigned_to_users WHERE name = "Inny" AND user_id = :userId)
                WHERE payment_method_assigned_to_user_id = :idDeletedCategory';

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->bindValue(':idDeletedCategory', $deletedCategory, PDO::PARAM_INT);
        $query->execute();
    }
}
