<?php

namespace App\Models;

use PDO;

class ExpenseCategory extends BudgetCategory
{
    protected const NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS = "expenses_category_assigned_to_users";
    protected const NAME_TABLE_WITH_BUDGET_ITEMS = "expenses";
    protected const NAME_COLUMN_WITH_CATEGORY_ASSIGNED_TO_USER_ID = "expense_category_assigned_to_user_id";
    protected const NAME_CATEGORY_WHICH_ASSIGN_BUDGET_ITEMS_FROM_REMOVED_CATEGORY = "Inne wydatki";

    public function save()
    {
        if (empty($this->errors)) {
            if (isset($this->limitAmount)) {
                return $this->saveWithLimit();
            } else {
                return $this->saveWithoutLimit();
            }
        }
        return false;
    }

    protected function saveWithLimit()
    {
        $sql = "INSERT INTO " . static::NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS .
            " VALUES (NULL, :userId, :nameCategory, (SELECT icon_id FROM icons WHERE icon = :nameIcon), :limit)";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->bindValue(':nameCategory', $this->nameCategory, PDO::PARAM_STR);
        $query->bindValue(':nameIcon', $this->icon, PDO::PARAM_STR);
        $query->bindValue(':limit', $this->limitAmount, PDO::PARAM_STR);
        return $query->execute();
    }

    protected function saveWithoutLimit()
    {
        $sql = "INSERT INTO " . static::NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS .
            " VALUES (NULL, :userId, :nameCategory, (SELECT icon_id FROM icons WHERE icon = :nameIcon), NULL)";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->bindValue(':nameCategory', $this->nameCategory, PDO::PARAM_STR);
        $query->bindValue(':nameIcon', $this->icon, PDO::PARAM_STR);
        return $query->execute();
    }

    public function change()
    {
        $this->validate();

        if (empty($this->errors)) {

            if (isset($this->limitAmount)) {
                return $this->changeWithLimit();
            } else {
                return $this->changeWithoutLimit();
            }
        }
        return false;
    }

    protected function changeWithLimit()
    {
        $sql = "UPDATE " . static::NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS .
            " SET name = :nameCategory, icon_id = (SELECT icon_id FROM icons WHERE icon = :nameIcon), limit_category = :limit
        WHERE id = :idPreviousCategory";

        $db = static::getDataBase();
        $query = $db->prepare($sql);

        $query->bindValue(':nameCategory', $this->nameCategory, PDO::PARAM_STR);
        $query->bindValue(':nameIcon', $this->icon, PDO::PARAM_STR);
        $query->bindValue(':limit', $this->limitAmount, PDO::PARAM_STR);
        $query->bindValue(':idPreviousCategory', $this->previousCategory, PDO::PARAM_INT);
        return $query->execute();
    }

    protected function changeWithoutLimit()
    {
        $sql = "UPDATE " . static::NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS .
            " SET name = :nameCategory, icon_id = (SELECT icon_id FROM icons WHERE icon = :nameIcon), limit_category = NULL
        WHERE id = :idPreviousCategory";

        $db = static::getDataBase();
        $query = $db->prepare($sql);

        $query->bindValue(':nameCategory', $this->nameCategory, PDO::PARAM_STR);
        $query->bindValue(':nameIcon', $this->icon, PDO::PARAM_STR);
        $query->bindValue(':idPreviousCategory', $this->previousCategory, PDO::PARAM_INT);
        return $query->execute();
    }
}
