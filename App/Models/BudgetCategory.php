<?php

namespace App\Models;

use PDO;

class BudgetCategory extends \Core\Model
{
    protected const NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS = "";
    protected const NAME_COLUMN_WITH_BUDGET_ITEMS_ASSIGNED_TO_USER_ID = "";
    protected const NAME_TABLE_WITH_BUDGET_ITEMS = "";
    protected const NAME_CATEGORY_WITH_ASSIGNED_BUDGET_ITEMS_AFTER_REMOVED_CATEGORY = "";

    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getNameTableWithBudgetItemsAssignedToUsers(): string
    {
        return static::NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS;
    }

    public function getNameTableWithBudgetItems(): string
    {
        return static::NAME_TABLE_WITH_BUDGET_ITEMS;
    }

    public function getCategoryWithAssignedBudgetItemsAfterRemovecCategory(): string
    {
        return static::NAME_CATEGORY_WITH_ASSIGNED_BUDGET_ITEMS_AFTER_REMOVED_CATEGORY;
    }

    public function getNameColumnWithBudgetItemsAssignedToUserId(): string
    {
        return static::NAME_COLUMN_WITH_BUDGET_ITEMS_ASSIGNED_TO_USER_ID;
    }

    public function validate()
    {
        if ($this->name == '') {
            $this->errors[] = 'Wpisz nazwę kategorii';
        }

        if ($this->icon == '') {
            $this->errors[] = 'Wybierz ikonę';
        }
    }

    public function save()
    {
        if (empty($this->errors)) {
            $sql = "INSERT INTO {$this->getNameTableWithBudgetItemsAssignedToUsers()}
                    VALUES (NULL, :userId, :nameCategory, (SELECT icon_id FROM icons WHERE icon = :nameIcon))";

            $db = static::getDataBase();
            $query = $db->prepare($sql);
            $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
            $query->bindValue(':nameCategory', $this->name, PDO::PARAM_STR);
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

            $query->bindValue(':nameCategory', $this->name, PDO::PARAM_STR);
            $query->bindValue(':nameIcon', $this->icon, PDO::PARAM_STR);
            $query->bindValue(':idPreviousCategory', $this->previousCategory, PDO::PARAM_INT);
            return $query->execute();
        }
        return false;
    }

    public function delete()
    {
        foreach ($this->categoriesToDelete as $category) {
            $sql = "DELETE FROM {$this->getNameTableWithBudgetItemsAssignedToUsers()} 
                    WHERE id = :idCategory;
                    
                    UPDATE {$this->getNameTableWithBudgetItems()}
                    SET {$this->getNameColumnWithBudgetItemsAssignedToUserId()} = 
                        (SELECT id 
                        FROM {$this->getNameTableWithBudgetItemsAssignedToUsers()}  
                        WHERE name = {$this->getCategoryWithAssignedBudgetItemsAfterRemovecCategory()} AND user_id = :userId)
                    WHERE  {$this->getNameColumnWithBudgetItemsAssignedToUserId()} = :idCategory";

            $db = static::getDataBase();
            $query = $db->prepare($sql);

            $query->bindValue(':idCategory', $category, PDO::PARAM_INT);
            $query->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_INT);
            if ($query->execute() == false) {
                return false;
            };
        }
        return true;
    }
}
