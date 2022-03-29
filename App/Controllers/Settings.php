<?php

namespace App\Controllers;

use Core\View;
use App\Models\IncomeCategory;

class Settings extends Authenticated
{
    public function showAction()
    {
        $userIncomeCategories = IncomeCategory::findCategories();
        View::renderTemplate('Settings/show.html', [
            'incomeCategories' => $userIncomeCategories
        ]);
    }
}
