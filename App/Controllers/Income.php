<?php

namespace App\Controllers;

use App\Models\User;
use Core\View;

class Income extends Authenticated
{
    public function addAction()
    {
        $user = User::findByID($_SESSION['userId']);
        View::renderTemplate('Income/add.html', [
            'user' => $user
        ]);
    }
}
