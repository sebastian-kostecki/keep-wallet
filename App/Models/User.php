<?php

namespace App\Models;

use PDO;
use App\Token;
use App\Mail;
use Core\View;

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
        $this->validateNewUser();

        if (empty($this->errors)) {
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $token = new Token;
            $hashed_token = $token->getHash($token);
            $this->activation_token = $token->getValue();

            $db = static::getDataBase();
            $newUserQuery = $db->prepare('INSERT INTO users (username, password, email, activation_hash) VALUES (:name, :password, :email, :hashed_token)');
            $newUserQuery->bindValue(':name', $this->name, PDO::PARAM_STR);
            $newUserQuery->bindValue(':password', $password_hash, PDO::PARAM_STR);
            $newUserQuery->bindValue(':email', $this->email, PDO::PARAM_STR);
            $newUserQuery->bindValue(':hashed_token', $hashed_token, PDO::PARAM_STR);

            return $newUserQuery->execute();
        }
        return false;
    }

    public function validateNewUser()
    {
        if ($this->name == '') {
            $this->errors[] = 'Wpisz imię';
        }

        if (preg_match("/.*[$&+,:;=?[\]@#|{}'<>.^*()%!-\/]+.*/i", $this->name)) {
            $this->errors[] = 'Imię nie może zawierać znaków specjalnych';
        }

        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Wpisz poprawny email';
        }
        if ($this->isEmailExists($this->email, $this->id ?? null)) {
            $this->errors[] = 'Podany email jest zajęty';
        }

        if (strlen($this->password) < 8) {
            $this->errors[] = 'Hasło musi zawierać przynajmniej 8 znaków';
        }
        if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
            $this->errors[] = 'Hasło powinno zawierać przynajmniej jedną literę';
        }
        if (preg_match('/.*\d+.*/i', $this->password) == 0) {
            $this->errors[] = 'Hasło powinno zawierać przynajmniej jedną liczbę';
        }
    }

    public static function isEmailExists($email, $ignore_id = null)
    {
        $user = static::findByEmail($email);
        if ($user) {
            if ($user->id != $ignore_id) {
                return true;
            }
        }
        return false;
    }

    public static function isNameExists($name)
    {
        $user = static::findByName($name);
        if ($user) {
            return true;
        }
        return false;
    }

    public static function findByEmail($email)
    {
        $db = static::getDataBase();
        $query = $db->prepare('SELECT * FROM users WHERE email = :email');
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetch();
    }

    public static function findByName($name)
    {
        $db = static::getDataBase();
        $query = $db->prepare('SELECT * FROM users WHERE username = :name');
        $query->bindValue(':name', $name, PDO::PARAM_STR);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetch();
    }

    public function sendActivationEmail()
    {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/signup/activate/' . $this->activation_token;

        $htmlContent = View::getTemplate('Signup/activationEmail.html', ['url' => $url]);
        $txtContent = View::getTemplate('Signup/activationEmail.txt', ['url' => $url]);

        Mail::sendMail($this->email, 'Aktywacja konta', $htmlContent, $txtContent);
    }
}
