<?php

namespace App\Controllers;

use App\Models\User;

class Account extends \Core\Controller
{
    public function validateEmailAction()
    {
        $isValidEmail = !User::isEmailExists($_GET['email']);

        header('Content-type: application/json');
        echo json_encode($isValidEmail);
    }
}
