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

    public function changeAction()
    {
        $expense = new Expenses($_POST);
        if ($expense->change()) {
            Flash::addMessage('Zmieniono wybrany wydatek');
            $this->redirect('/balance/show');
        } else {
            Flash::addMessage('Nieudana zmiana wydatku', Flash::DANGER);
            $this->redirect('/balance/show');
        }
    }

    public function removeAction()
    {
        $expense = new Expenses($_POST);
        if ($expense->remove()) {
            Flash::addMessage('Usunięto wybrany wydatek');
            $this->redirect('/balance/show');
        } else {
            Flash::addMessage('Nieudane usunięcie wydatku', Flash::DANGER);
            $this->redirect('/balance/show');
        }
    }

    public function getLimitAction()
    {
        echo json_encode(ExpenseCategory::getLimit($this->route_params['id']), JSON_UNESCAPED_UNICODE);
    }
}
