<?php

namespace App\Controllers;

use App\Models\Expenses;
use App\Models\ExpenseCategory;
use App\Models\PaymentMethod;
use Core\View;
use App\Flash;

class Expense extends Authenticated
{
    public function newAction()
    {
        $expenseCategories = ExpenseCategory::findCategories();
        $paymentMethods = PaymentMethod::findCategories();
        View::renderTemplate('Expense/new.html', [
            'expenseCategories' => $expenseCategories,
            'paymentMethods' => $paymentMethods
        ]);
    }

    public function saveAction()
    {
        $expense = new Expenses($_POST);
        if ($expense->save()) {
            Flash::addMessage('Dodano nowy wydatek');
            $this->redirect('/menu');
        } else {
            $expenseCategories = ExpenseCategory::findCategories();
            $paymentMethods = PaymentMethod::findCategories();
            View::renderTemplate('Expense/new.html', [
                'expense' => $expense,
                'expenseCategories' => $expenseCategories,
                'paymentMethods' => $paymentMethods
            ]);
        }
    }
}
