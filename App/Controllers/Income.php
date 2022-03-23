<?php

namespace App\Controllers;

use App\Models\IncomeCategory;
use App\Models\User;
use App\Models\Incomes;
use Core\View;

class Income extends Authenticated
{
    public function newAction()
    {
        $user = User::findByID($_SESSION['userId']);
        $userIncomeCategories = IncomeCategory::findCategories($user);
        View::renderTemplate('Income/new.html', [
            'user' => $user,
            'incomeCategories' => $userIncomeCategories
        ]);
    }

    public function saveAction()
    {
        $income = new Incomes($_POST);
        $income->save();
    }
}
