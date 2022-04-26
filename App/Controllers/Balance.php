<?php

namespace App\Controllers;

use App\Models\UserExpenses;
use App\Models\UserIncomes;
use Core\View;
use App\Models\IncomeCategory;
use App\Models\ExpenseCategory;
use App\Models\Expenses;
use App\Models\Incomes;
use App\Models\PaymentMethod;

class Balance extends Authenticated
{
    public function selectAction()
    {
        $_SESSION['chosenPeriod'] = $_POST['chosenPeriod'];
        $_SESSION['nameSelectedPeriod'] = $_POST['selectPeriod'];

        $this->redirect('/balance/show');
    }

    public function showAction()
    {
        $incomesUserGroupByCategories = Incomes::getUserIncomesGroupByCategories();
        $allUserIncomes = Incomes::getAllUserIncomes();

        $expensesUserGroupByCategories = Expenses::getUserExpensesGroupByCategories();
        $allUseExpenses = Expenses::getAllUserExpenses();

        $userIncomeCategories = IncomeCategory::findCategories();
        $expenseCategories = ExpenseCategory::findCategories();
        $paymentMethods = PaymentMethod::findCategories();

        View::renderTemplate('Balance/balance.html', [
            'incomesGroupByCategories' => $incomesUserGroupByCategories,
            'allIncomes' => $allUserIncomes,
            'expensesGroupByCategories' => $expensesUserGroupByCategories,
            'allExpenses' => $allUseExpenses,
            'selectPeriod' => $_SESSION['nameSelectedPeriod'],
            'chosenPeriod' => $_SESSION['chosenPeriod'],
            'incomeCategories' => $userIncomeCategories,
            'expenseCategories' => $expenseCategories,
            'paymentMethods' => $paymentMethods
        ]);
    }
}
