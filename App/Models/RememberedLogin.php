<?php

namespace App\Models;

use App\Token;
use PDO;

class RememberedLogin extends \Core\Model
{
    public static function findByToken($token)
    {
        $token = new Token($token);
        $token_hash = $token->getHash();

        $db = static::getDataBase();
        $query = $db->prepare('SELECT * FROM remebered_logins WHERE token_hash = :token_hash');
        $query->bindValue(':token_hash', $token_hash, PDO::PARAM_STR);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $query->fetch();
    }

    public function getUser()
    {
        return User::findByID($this->user_id);
    }

    public function hasExpired()
    {
        return strtotime($this->expiry_at) < time();
    }

    public function delete()
    {
        $db = static::getDataBase();
        $query = $db->prepare("DELETE FROM remebered_logins WHERE token_hash = :token_hash");
        $query->bindValue(':token_hash', $this->token_hash, PDO::PARAM_STR);
        $query->execute();
    }
}
