<?php

namespace App\Controllers;

use App\Models\IncomeCategory;
use App\Models\User;
use Core\View;

class Income extends Authenticated
{
    public function newAction()
    {
        $user = User::findByID($_SESSION['userId']);
        $userIncomeCategories = IncomeCategory::findCategories($user);
        //trzeba pobrać kategorie po userze
        View::renderTemplate('Income/new.html', [
            'user' => $user,
            'incomeCategories' => $userIncomeCategories
        ]);
    }
}
