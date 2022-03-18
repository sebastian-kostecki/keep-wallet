<?php

namespace App\Models;

use PDO;

class User extends \Core\Model
{
    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function saveUser()
    {
        $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

        $db = static::getDataBase();
        $newUserQuery = $db->prepare('INSERT INTO users VALUES (NULL, :name, :password, :email)');
        $newUserQuery->bindValue(':name', $this->name, PDO::PARAM_STR);
        $newUserQuery->bindValue(':password', $password_hash, PDO::PARAM_STR);
        $newUserQuery->bindValue(':email', $this->email, PDO::PARAM_STR);

        return $newUserQuery->execute();
    }

    public function validateNewUser()
    {
        if ($this->name == '') {
            $this->errors[] = 'Wpisz imię';
        }
        if (preg_match('/.*[\$&\+,:;=?[\]@#|{}\'<>.^*()%!-/]+.*/i', $this->name)) {
            $this->errors[] = 'Imię nie może zawierać znaków specjalnych';
        }
    }
}
