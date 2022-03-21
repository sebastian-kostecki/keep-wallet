<?php

namespace App\Controllers;

use Core\View;
use App\Models\User;

class Menu extends Authenticated
{
    public function showAction()
    {
        $user = User::findByID($_SESSION['userId']);
        View::renderTemplate('Menu/menu.html', [
            'user' => $user
        ]);
    }
}
