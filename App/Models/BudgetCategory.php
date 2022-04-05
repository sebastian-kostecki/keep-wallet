<?php

namespace App\Models;

use PDO;

class BudgetCategory extends \Core\Model
{
    protected const NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS = "";
    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getName(): string
    {
        return static::NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS;
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
            $sql = "INSERT INTO {$this->getName()}
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
}
