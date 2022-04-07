<?php

namespace App\Models;

use PDO;

abstract class BudgetCategory extends \Core\Model
{
    protected const NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS = "";

    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function getNameTableWithBudgetItemsAssignedToUsers(): string
    {
        return static::NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS;
    }


    abstract static function assignContentOfDeletedCategoryToOthers($category);

    public function validate()
    {
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
                FROM " . static::getNameTableWithBudgetItemsAssignedToUsers() . " NATURAL JOIN icons
                WHERE " . static::getNameTableWithBudgetItemsAssignedToUsers() . ".user_id = :userId";

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
            $sql = "INSERT INTO {$this->getNameTableWithBudgetItemsAssignedToUsers()}
                    VALUES (NULL, :userId, :nameCategory, (SELECT icon_id FROM icons WHERE icon = :nameIcon))";

            $db = static::getDataBase();
            $query = $db->prepare($sql);
            $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
            $query->bindValue(':nameCategory', $this->nameCategory, PDO::PARAM_STR);
            $query->bindValue(':nameIcon', $this->icon, PDO::PARAM_STR);

            var_dump($query);
            return $query->execute();
        }
        return false;
    }

    public function change()
    {
        $this->validate();

        if (empty($this->errors)) {

            $sql = "UPDATE {$this->getNameTableWithBudgetItemsAssignedToUsers()}
                    SET name = :nameCategory, icon_id = (SELECT icon_id FROM icons WHERE icon = :nameIcon)
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
        foreach ($this->categoriesToDelete as $category) {
            static::assignContentOfDeletedCategoryToOthers($category);
            $sql = "DELETE FROM {$this->getNameTableWithBudgetItemsAssignedToUsers()} 
                WHERE id = :idCategory";

            $db = static::getDataBase();
            $query = $db->prepare($sql);

            $query->bindValue(':idCategory', $category, PDO::PARAM_INT);
            if ($query->execute() == false) {
                return false;
            };
        }
        return true;
    }
}
