<?php

namespace App\Controllers;

use App\Flash;
use App\Models\IncomeCategory;
use App\Models\Incomes;
use Core\View;

class Income extends Authenticated
{
    public function newAction()
    {
        $userIncomeCategories = IncomeCategory::findCategories();
        View::renderTemplate('Income/new.html', [
            'incomeCategories' => $userIncomeCategories
        ]);
    }

    public function saveAction()
    {
        $income = new Incomes($_POST);
        if ($income->save()) {
            Flash::addMessage('Dodano nowy przychód');
            $this->redirect('/menu');
        } else {
            $userIncomeCategories = IncomeCategory::findCategories();
            View::renderTemplate('Income/new.html', [
                'income' => $income,
                'incomeCategories' => $userIncomeCategories
            ]);
        }
    }

    public function changeAction()
    {
        $income = new Incomes($_POST);

        if ($income->change()) {
            Flash::addMessage('Zmieniono wybrany przychód');
            $this->redirect('/balance/show');
        } else {
            Flash::addMessage('Nieudana zmiana przychodu', Flash::DANGER);
            $this->redirect('/balance/show');
        }
    }

    public function removeAction()
    {
        $income = new Incomes($_POST);
        if ($income->remove()) {
            Flash::addMessage('Usunięto wybrany przychód');
            $this->redirect('/balance/show');
        } else {
            Flash::addMessage('Nieudane usunięcie przychodu', Flash::DANGER);
            $this->redirect('/balance/show');
        }
    }
}
