<?php

namespace App\Models;

use PDO;

class PaymentMethod extends BudgetCategory
{
    protected const NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS = "payment_methods_assigned_to_users";

    public static function findPaymentMethods()
    {
        $sql = "SELECT * 
                FROM payment_methods_assigned_to_users NATURAL JOIN icons
                WHERE payment_methods_assigned_to_users.user_id = :userId";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetchAll();
    }

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

    // public static function remove($paymentMehodsToDelete)
    // {
    //     foreach ($paymentMehodsToDelete as $paymentMethodToDelete) {
    //         if (static::assignDeletedCategoriesIncomesToOtherIncomes($paymentMethodToDelete)) {
    //             $sql = 'DELETE FROM payment_methods_assigned_to_users 
    //                     WHERE id = :idCategory';

    //             $db = static::getDataBase();
    //             $query = $db->prepare($sql);

    //             $query->bindValue(':idCategory', $paymentMethodToDelete, PDO::PARAM_INT);
    //             if ($query->execute() == false) {
    //                 return false;
    //             }
    //         } else {
    //             return false;
    //         }
    //     }
    //     return true;
    // }

    // protected static function assignDeletedCategoriesIncomesToOtherIncomes($categoryId)
    // {
    //     $sql = 'UPDATE expenses
    //             SET payment_method_assigned_to_user_id = (SELECT id FROM incomes_category_assigned_to_users WHERE name = "Inne przychody" AND user_id = :userId)
    //             WHERE income_category_assigned_to_user_id = :idDeletedCategory';

    //     $db = static::getDataBase();
    //     $query = $db->prepare($sql);

    //     $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
    //     $query->bindValue(':idDeletedCategory', $categoryId, PDO::PARAM_INT);
    //     return $query->execute();
    // }
}
