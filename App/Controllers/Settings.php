<?php

namespace App\Controllers;

use Core\View;
use App\Models\IncomeCategory;
use App\Models\ExpenseCategory;

class Settings extends Authenticated
{
    public function showAction()
    {
        $userIncomeCategories = IncomeCategory::findCategories();
        $expenseCategories = ExpenseCategory::findCategories();
        View::renderTemplate('Settings/show.html', [
            'incomeCategories' => $userIncomeCategories,
            'expenseCategories' => $expenseCategories
        ]);
    }
}
