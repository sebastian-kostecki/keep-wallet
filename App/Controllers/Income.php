<?php

namespace App\Controllers;

use App\Flash;
use App\Models\IncomeCategory;
use App\Models\User;
use App\Models\Incomes;
use Core\View;

class Income extends Authenticated
{
    public function newAction()
    {
        $user = User::findByID($_SESSION['userId']);
        $userIncomeCategories = IncomeCategory::findCategories($user);
        View::renderTemplate('Income/new.html', [
            'user' => $user,
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
            $user = User::findByID($_SESSION['userId']);
            $userIncomeCategories = IncomeCategory::findCategories($user);
            View::renderTemplate('Income/new.html', [
                'income' => $income,
                'user' => $user,
                'incomeCategories' => $userIncomeCategories
            ]);
        }
    }
}
