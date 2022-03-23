<?php

namespace App\Models;

class Income extends \Core\Model
{
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function save()
    {
        //walidacja danych
        //zapisanie do bazy danych
    }
}
