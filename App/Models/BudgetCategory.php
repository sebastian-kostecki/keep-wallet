<?php

namespace App\Models;

use PDO;

abstract class BudgetCategory extends \Core\Model
{
    protected const NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS = "";
    protected const NAME_TABLE_WITH_BUDGET_ITEMS = "";
    protected const NAME_COLUMN_WITH_CATEGORY_ASSIGNED_TO_USER_ID = "";
    protected const NAME_CATEGORY_WHICH_ASSIGN_BUDGET_ITEMS_FROM_REMOVED_CATEGORY = "";

    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    protected static function getNameTableWithBudgetItemsAssignedToUsers(): string
    {
        return static::NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS;
    }

    protected static function getNameTableWithBudgetItems(): string
    {
        return static::NAME_TABLE_WITH_BUDGET_ITEMS;
    }

    protected static function getNameColumnWithCategoryAssignedToUserId(): string
    {
        return static::NAME_COLUMN_WITH_CATEGORY_ASSIGNED_TO_USER_ID;
    }

    protected static function getCategoryWhichAssignBudgetItemsFromRemovedCategory(): string
    {
        return static::NAME_CATEGORY_WHICH_ASSIGN_BUDGET_ITEMS_FROM_REMOVED_CATEGORY;
    }

    public function validate()
    {
        if ($this->previousCategory == '') {
            $this->errors[] = 'Wybierz kategorię do zmiany';
        }

        if ($this->nameCategory == '') {
            $this->errors[] = 'Wpisz nazwę kategorii';
        }

        if ($this->icon == '') {
            $this->errors[] = 'Wybierz ikonę';
        }
    }

    public static function findCategories()
    {
        $sql = "SELECT * 
                FROM " . static::NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS . " NATURAL JOIN icons
                WHERE " . static::NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS . ".user_id = :userId";

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
            $sql = "INSERT INTO " . static::NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS .
                " VALUES (NULL, :userId, :nameCategory, (SELECT icon_id FROM icons WHERE icon = :nameIcon))";

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

            $sql = "UPDATE " . static::NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS .
                " SET name = :nameCategory, icon_id = (SELECT icon_id FROM icons WHERE icon = :nameIcon)
                    WHERE id = :idPreviousCategory";

            $db = static::getDataBase();
            $query = $db->prepare($sql);

            $query->bindValue(':nameCategory', $this->nameCategory, PDO::PARAM_STR);
            $query->bindValue(':nameIcon', $this->icon, PDO::PARAM_STR);
            $query->bindValue(':idPreviousCategory', $this->previousCategory, PDO::PARAM_INT);
            return $query->execute();
        }
        return false;
    }

    public function delete()
    {
        $sql = "UPDATE " . static::NAME_TABLE_WITH_BUDGET_ITEMS .
            " SET " . static::NAME_COLUMN_WITH_CATEGORY_ASSIGNED_TO_USER_ID . " = 
                    (SELECT id 
                    FROM " . static::NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS .
            " WHERE name = '" . static::NAME_CATEGORY_WHICH_ASSIGN_BUDGET_ITEMS_FROM_REMOVED_CATEGORY . "' AND user_id = :userId)
                WHERE " . static::NAME_COLUMN_WITH_CATEGORY_ASSIGNED_TO_USER_ID . " = :idCategory;
                
                DELETE FROM " . static::NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS .
            " WHERE id = :idCategory";

        $db = static::getDataBase();
        $query = $db->prepare($sql);

        $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $query->bindValue(':idCategory', $this->id, PDO::PARAM_INT);
        return $query->execute();
    }
}
