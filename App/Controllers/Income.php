<?php

namespace App\Controllers;

use App\Models\User;
use Core\View;

class Income extends Authenticated
{
    public function newAction()
    {
        $user = User::findByID($_SESSION['userId']);
        //trzeba pobrać kategorie po userze
        View::renderTemplate('Income/new.html', [
            'user' => $user
        ]);
    }
}
