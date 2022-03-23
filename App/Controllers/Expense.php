<?php

namespace App\Controllers;

use App\Models\User;

class Expense extends \Core\Controller
{
    public function newAction()
    {
        $user = User::findByID($_SESSION['userId']);
    }
}
