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
        $paymentMethods = PaymentMethod::findCategories();
        $icons = Icon::getIcons();

        View::renderTemplate('Settings/show.html', [
            'incomeCategories' => $userIncomeCategories,
            'expenseCategories' => $expenseCategories,
            'paymentMethods' => $paymentMethods,
            'icons' => $icons
        ]);
    }

    public function changeUserDataAction()
    {
        $user = User::findByID($_SESSION['userId']);

        if ($user->changeUserData($_POST) && empty($_POST['login'])) {
            Flash::addMessage("Zmieniłeś hasło");
            $this->redirect('/menu');
        } else if ($user->changeUserData($_POST) && empty($_POST['password'])) {
            Flash::addMessage("Zmieniłeś nazwę użytkownika");
            $this->redirect('/menu');
        } else if ($user->changeUserData($_POST)) {
            Flash::addMessage("Zmieniłeś hasło i nazwę użytkownika");
            $this->redirect('/menu');
        } else {
            Flash::addMessage("Nieudana zmiana danych użytkownika", Flash::DANGER);
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
        $categoryToDelete = new IncomeCategory($_POST);

        if ($categoryToDelete->delete()) {
            Flash::addMessage("Usunąłeś kategorię przychodów");
            $this->redirect('/menu');
        } else {
            Flash::addMessage("Nieudane usunięcie kategorii przychodów", Flash::DANGER);
            $this->redirect('/settings');
        }
    }

    public function addExpenseCategoryAction()
    {
        $expenseCategory = new ExpenseCategory($_POST);

        if ($expenseCategory->save()) {
            Flash::addMessage("Dodałeś nową kategorię wydatków");
            $this->redirect('/menu');
        } else {
            Flash::addMessage("Nieudane dodanie nowej kategorii wydatków", Flash::DANGER);
            $this->redirect('/settings');
        }
    }

    public function changeExpenseCategoryAction()
    {
        $expenseCategory = new ExpenseCategory($_POST);

        if ($expenseCategory->change()) {
            Flash::addMessage("Zmieniłeś kategorię wydatków");
            $this->redirect('/menu');
        } else {
            Flash::addMessage("Nieudana zmiana kategorii wydatków", Flash::DANGER);
            $this->redirect('/settings');
        }
    }

    public function deleteExpenseCategoryAction()
    {
        $categoryToDelete = new ExpenseCategory($_POST);

        if ($categoryToDelete->delete()) {
            Flash::addMessage("Usunąłeś kategorię wydatków");
            $this->redirect('/menu');
        } else {
            Flash::addMessage("Nieudane usunięcie kategorii wydatków", Flash::DANGER);
            $this->redirect('/settings');
        }
    }

    public function addPaymentMethodAction()
    {
        $paymentMethod = new PaymentMethod($_POST);

        if ($paymentMethod->save()) {
            Flash::addMessage("Dodałeś nowy sposób płatności");
            $this->redirect('/menu');
        } else {
            Flash::addMessage("Nieudane dodanie nowego sposobu płatności", Flash::DANGER);
            $this->redirect('/settings');
        }
    }

    public function changePaymentMethodAction()
    {
        $paymentMethod = new PaymentMethod($_POST);

        if ($paymentMethod->change()) {
            Flash::addMessage("Zmieniłeś wybrany sposób płatności");
            $this->redirect('/menu');
        } else {
            Flash::addMessage("Nieudana zmiana sposobu płatności", Flash::DANGER);
            $this->redirect('/settings');
        }
    }

    public function deletePaymentMethodAction()
    {
        $paymentMethodToDelete = new PaymentMethod($_POST);

        if ($paymentMethodToDelete->delete()) {
            Flash::addMessage("Usunąłeś sposob płatności");
            $this->redirect('/menu');
        } else {
            Flash::addMessage("Nieudane usunięcie sposobu płatności", Flash::DANGER);
            $this->redirect('/settings');
        }
    }
}
