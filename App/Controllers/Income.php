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
}
