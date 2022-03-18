<?php

namespace App\Models;

class User extends \Core\Model
{
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function saveUser()
    {
    }
}
