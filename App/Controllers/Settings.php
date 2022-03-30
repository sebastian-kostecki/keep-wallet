<?php

namespace App\Controllers;

use Core\View;
use App\Models\IncomeCategory;
use App\Models\ExpenseCategory;
use App\Models\PaymentMethod;
use App\Models\Icon;

class Settings extends Authenticated
{
    public function showAction()
    {
        $userIncomeCategories = IncomeCategory::findCategories();
        $expenseCategories = ExpenseCategory::findCategories();
        $paymentMethods = PaymentMethod::findPaymentMethods();
        $icons = Icon::getIcons();

        View::renderTemplate('Settings/show.html', [
            'incomeCategories' => $userIncomeCategories,
            'expenseCategories' => $expenseCategories,
            'paymentMethods' => $paymentMethods,
            'icons' => $icons
        ]);
    }

    public function changeNameAction()
    {
        var_dump($_POST);
    }

    public function changePasswordAction()
    {
        var_dump($_POST);
    }

    public function addIncomeCategoryAction()
    {
        var_dump($_POST);
    }

    public function changeIncomeCategoryAction()
    {
        var_dump($_POST);
    }

    public function deleteIncomeCategoryAction()
    {
        var_dump($_POST);
    }
}
