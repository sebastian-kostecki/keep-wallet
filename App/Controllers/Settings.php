<?php

namespace App\Controllers;

use Core\View;
use App\Models\IncomeCategory;
use App\Models\ExpenseCategory;
use App\Models\PaymentMethod;

class Settings extends Authenticated
{
    public function showAction()
    {
        $userIncomeCategories = IncomeCategory::findCategories();
        $expenseCategories = ExpenseCategory::findCategories();
        $paymentMethods = PaymentMethod::findPaymentMethods();

        View::renderTemplate('Settings/show.html', [
            'incomeCategories' => $userIncomeCategories,
            'expenseCategories' => $expenseCategories,
            'paymentMethods' => $paymentMethods
        ]);
    }
}
