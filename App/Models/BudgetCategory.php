<?php

namespace App\Models;

class BudgetCategory extends \Core\Model
{
    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
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
}
