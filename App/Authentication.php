<?php

namespace App;

class Authentication
{
    public static function login($user, $rememberMe)
    {
        session_regenerate_id(true);
        $_SESSION['userId'] = $user->id;

        if ($rememberMe) {
            if ($user->rememberLogin()) {
                setcookie('remember_me', $user->remember_token, $user->expiry_timestamp, '/');
            }
        }
    }
}
