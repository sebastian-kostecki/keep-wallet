<?php

namespace App\Models;

use PDO;

class PaymentMethod extends BudgetCategory
{
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

    public function save()
    {
        if (empty($this->errors)) {
            $sql = "INSERT INTO payment_methods_assigned_to_users
                    VALUES (NULL, :userId, :namePaymentMethod, (SELECT icon_id FROM icons WHERE icon = :nameIcon))";

            $db = static::getDataBase();
            $query = $db->prepare($sql);
            $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
            $query->bindValue(':namePaymentMethod', $this->name, PDO::PARAM_STR);
            $query->bindValue(':nameIcon', $this->icon, PDO::PARAM_STR);
            return $query->execute();
        }
        return false;
    }

    public function change()
    {
        $this->validate();

        if (empty($this->errors)) {

            $sql = 'UPDATE payment_methods_assigned_to_users 
                    SET name = :namePaymentMethod, icon_id = (SELECT icon_id FROM icons WHERE icon = :nameIcon)
                    WHERE id = :idOldPaymentMethod';

            $db = static::getDataBase();
            $query = $db->prepare($sql);

            $query->bindValue(':namePaymentMethod', $this->name, PDO::PARAM_STR);
            $query->bindValue(':nameIcon', $this->icon, PDO::PARAM_STR);
            $query->bindValue(':idOldPaymentMethod', $this->oldPaymentMethod, PDO::PARAM_INT);
            return $query->execute();
        }
        return false;
    }

    public static function remove($paymentMehodsToDelete)
    {
        foreach ($paymentMehodsToDelete as $paymentMethodToDelete) {
            if (static::assignDeletedCategoriesIncomesToOtherIncomes($paymentMethodToDelete)) {
                $sql = 'DELETE FROM payment_methods_assigned_to_users 
                        WHERE id = :idCategory';

                $db = static::getDataBase();
                $query = $db->prepare($sql);

                $query->bindValue(':idCategory', $paymentMethodToDelete, PDO::PARAM_INT);
                if ($query->execute() == false) {
                    return false;
                }
            } else {
                return false;
            }
        }
        return true;
    }

    protected static function assignDeletedCategoriesIncomesToOtherIncomes($categoryId)
    {
        $sql = 'UPDATE expenses
                SET payment_method_assigned_to_user_id = (SELECT id FROM incomes_category_assigned_to_users WHERE name = "Inne przychody" AND user_id = :userId)
                WHERE income_category_assigned_to_user_id = :idDeletedCategory';

        $db = static::getDataBase();
        $query = $db->prepare($sql);

        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->bindValue(':idDeletedCategory', $categoryId, PDO::PARAM_INT);
        return $query->execute();
    }




    public function delete()
    {
        foreach ($this->categoriesToDelete as $category) {
            $sql = 'DELETE FROM payment_methods_assigned_to_users 
            WHERE id = :idCategory';

            $db = static::getDataBase();
            $query = $db->prepare($sql);

            $query->bindValue(':idCategory', $category, PDO::PARAM_INT);
            $query->execute();
        }
    }
}
