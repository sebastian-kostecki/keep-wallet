<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\ExpenseCategory;
use App\Models\PaymentMethod;

class Expense extends \Core\Controller
{
    public function newAction()
    {
        $user = User::findByID($_SESSION['userId']);
        $expenseCategories = ExpenseCategory::findCategories($user);
        $paymentMethods = PaymentMethod::findPaymentMethods($user);
    }
}
