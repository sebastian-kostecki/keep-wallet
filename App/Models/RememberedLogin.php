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
}
