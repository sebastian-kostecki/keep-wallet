<?php

namespace App\Controllers;

use Core\View;
use App\Models\IncomeCategory;
use App\Models\ExpenseCategory;
use App\Models\PaymentMethod;
use App\Models\Icon;
use App\Models\User;
use App\Flash;

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
        $user = User::findByID($_SESSION['userId']);

        if ($user->changeName($_POST['name'])) {
            Flash::addMessage("Zmieniłeś nazwę użytkownika");
            $this->redirect('/menu');
        } else {
            Flash::addMessage("Nieudana zmiana nazwy użytkownika", Flash::DANGER);
            $this->redirect('/settings');
        }
    }

    public function changePasswordAction()
    {
        $user = User::findByID($_SESSION['userId']);

        if ($user->changePassword($_POST['password'])) {
            Flash::addMessage("Zmieniłeś hasło");
            $this->redirect('/menu');
        } else {
            Flash::addMessage("Nieudana zmiana hasła", Flash::DANGER);
            $this->redirect('/settings');
        }
    }

    public function addIncomeCategoryAction()
    {
        $incomeCategory = new IncomeCategory($_POST);

        if ($incomeCategory->save()) {
            Flash::addMessage("Dodałeś nową kategorię przychodów");
            $this->redirect('/menu');
        } else {
            Flash::addMessage("Nieudane dodanie nowej kategorii przychodów", Flash::DANGER);
            $this->redirect('/settings');
        }
    }

    public function changeIncomeCategoryAction()
    {
        $incomeCategory = new IncomeCategory($_POST);
        if ($incomeCategory->change()) {
            Flash::addMessage("Zmieniłeś kategorię przychodu");
            $this->redirect('/menu');
        } else {
            Flash::addMessage("Nieudana zmiana kategorii przychodów", Flash::DANGER);
            $this->redirect('/settings');
        }
    }

    public function deleteIncomeCategoryAction()
    {
        var_dump($_POST);
    }

    public function addExpenseCategoryAction()
    {
        var_dump($_POST);
    }

    public function changeExpenseCategoryAction()
    {
        var_dump($_POST);
    }

    public function deleteExpenseCategoryAction()
    {
        var_dump($_POST);
    }

    public function addPaymentMethodAction()
    {
        var_dump($_POST);
    }

    public function changePaymentMethodAction()
    {
        var_dump($_POST);
    }

    public function deletePaymentMethodAction()
    {
        var_dump($_POST);
    }
}
