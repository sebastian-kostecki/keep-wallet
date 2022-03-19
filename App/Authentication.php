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
                setcookie('rememberMe', $user->remember_token, $user->expiry_timestamp, '/');
            }
        }
    }

    public static function getReturnToPage()
    {
        return $_SESSION['returnTo'] ?? '/menu';
    }
}
