<?php

namespace App\Controllers;

use Core\View;
use App\Models\User;

class Password extends \Core\Controller
{
    public function forgotAction()
    {
        View::renderTemplate('Password/forgot.html');
    }

    public function requestResetAction()
    {
        User::sendPasswordReset($_POST['email']);
        View::renderTemplate('Password/sendInfo.html');
    }

    public function resetAction()
    {
        $token = $this->route_params['token'];
        $user = User::findByPasswordReset($token);

        if ($user) {
            View::renderTemplate('Password/resetPassword.html', [
                'token' => $token
            ]);
        } else {
            View::renderTemplate('Password/tokenExpired.html');
            exit();
        }
    }
}
