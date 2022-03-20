<?php

namespace App;

use App\Models\User;

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

    public static function logout()
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    }

    public static function getReturnToPage()
    {
        return $_SESSION['returnTo'] ?? '/menu';
    }

    public static function getUser()
    {
        if (isset($_SESSION['userId'])) {
            return User::findByID($_SESSION['userId']);
        }
    }
}
