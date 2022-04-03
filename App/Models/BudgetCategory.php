<?php

namespace App\Models;

abstract class BudgetCategory extends \Core\Model
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
        if ($this->nameCategory == '') {
            $this->errors[] = 'Wpisz nazwę kategorii';
        }

        if ($this->icon == '') {
            $this->errors[] = 'Wybierz ikonę';
        }
    }
}
