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
            $newUserQuery->execute();

            $db->query("INSERT INTO expenses_category_assigned_to_users (user_id, name, icon) SELECT users.id, expenses_category_default.name, expenses_category_default.icon  FROM expenses_category_default CROSS JOIN users WHERE users.id = (SELECT id FROM users WHERE username = '{$this->name}')");
            $db->query("INSERT INTO incomes_category_assigned_to_users (user_id, name, icon) SELECT users.id, incomes_category_default.name, incomes_category_default.icon FROM incomes_category_default CROSS JOIN users WHERE users.id = (SELECT id FROM users WHERE username = '{$this->name}')");
            $db->query("INSERT INTO payment_methods_assigned_to_users (user_id, name, icon) SELECT users.id, payment_methods_default.name, payment_methods_default.icon FROM payment_methods_default CROSS JOIN users WHERE users.id = (SELECT id FROM users WHERE username = '{$this->name}')");

            return true;
        }
        return false;
    }

    public function validateNewUser()
    {
        if ($this->name == '') {
            $this->errors[] = 'Wpisz imię';
        }

        if ($this->isNameExists($this->name)) {
            $this->errors[] = 'Podane imię jest zajęte';
        }

        if (preg_match("/.*[$&+,:;=?[\]@#|{}'<>.^*()%!-\/]+.*/i", $this->name)) {
            $this->errors[] = 'Imię nie może zawierać znaków specjalnych';
        }

        if ((strlen($this->name) < 2) || (strlen($this->name) > 50)) {
            $this->errors[] = 'Imię musi zawierać od 3 do 50 znaków';
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

    public static function findByID($id)
    {
        $db = static::getDataBase();
        $query = $db->prepare('SELECT * FROM users WHERE id = :id');
        $query->bindValue(':id', $id, PDO::PARAM_INT);
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

    public static function activateUser($userToken)
    {
        $token = new Token($userToken);
        $hashed_token = $token->getHash($token);

        $db = static::getDataBase();
        $stmt = $db->prepare('UPDATE users SET is_active = 1, activation_hash = null WHERE activation_hash = :hashed_token');
        $stmt->bindValue(':hashed_token', $hashed_token, PDO::PARAM_STR);

        $stmt->execute();
    }

    public static function authenticate($login, $password)
    {
        $user = static::findByEmail($login);
        if (!$user) {
            $user = static::findByName($login);
        }

        if ($user && $user->is_active) {
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return false;
    }

    public function rememberLogin()
    {
        $token = new Token;
        $token_hash = $token->getHash();
        $this->remember_token = $token->getValue();

        $this->expiry_timestamp = time() + 60 * 60 * 24 * 14;

        $sql = 'INSERT INTO remebered_logins (token_hash, user_id, expiry_at)
                VALUES (:token_hash, :user_id, :expiry_at)';

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':token_hash', $token_hash, PDO::PARAM_STR);
        $query->bindValue(':user_id', $this->id, PDO::PARAM_INT);
        $query->bindValue(':expiry_at', date('Y-m-d H:i:s', $this->expiry_timestamp), PDO::PARAM_STR);

        return $query->execute();
    }

    public static function sendPasswordReset($email)
    {
        $user = static::findByEmail($email);

        if ($user) {
            if ($user->startPasswordReset()) {
                $user->sendPasswordResetEmail();
            }
        }
    }
}
