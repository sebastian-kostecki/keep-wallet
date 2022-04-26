<?php

namespace App\Models;

use PDO;

abstract class BudgetItem extends \Core\Model
{
    protected const NAME_OF_TABLE_WITH_BUDGET_ITEMS = "";
    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function remove()
    {
        $sql = "DELETE FROM " . self::NAME_OF_TABLE_WITH_BUDGET_ITEMS .
            " WHERE id = :id";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $query->execute();
    }
}
