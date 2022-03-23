<?php

namespace App\Controllers;

use App\Models\Expenditure;
use App\Models\User;
use App\Models\ExpenseCategory;
use App\Models\PaymentMethod;
use Core\View;
use App\Flash;

class Expense extends \Core\Controller
{
    public function newAction()
    {
        $user = User::findByID($_SESSION['userId']);
        $expenseCategories = ExpenseCategory::findCategories($user);
        $paymentMethods = PaymentMethod::findPaymentMethods($user);
        View::renderTemplate('Expense/new.html', [
            'expenseCategories' => $expenseCategories,
            'paymentMethods' => $paymentMethods
        ]);
    }

    public function saveAction()
    {
        $expense = new Expenditure($_POST);
        if ($expense->save()) {
            Flash::addMessage('Dodano nowy wydatek');
            $this->redirect('/menu');
        } else {
            $user = User::findByID($_SESSION['userId']);
            $expenseCategories = ExpenseCategory::findCategories($user);
            $paymentMethods = PaymentMethod::findPaymentMethods($user);
            View::renderTemplate('Expense/new.html', [
                'expense' => $expense,
                'expenseCategories' => $expenseCategories,
                'paymentMethods' => $paymentMethods
            ]);
        }
    }
}