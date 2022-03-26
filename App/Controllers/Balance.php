<?php

namespace App\Controllers;

use App\Models\Expenditure;
use App\Models\Revenue;
use App\Models\UserExpenses;
use App\Models\UserIncomes;
use Core\View;

class Balance extends Authenticated
{
    public function showAction()
    {
        $chosenPeriod = $_POST['chosenPeriod'];
        $selectPeriod = $_POST['selectPeriod'];

        $incomesUserGroupByCategories = UserIncomes::getUserIncomesGroupByCategories($chosenPeriod);
        $allUserIncomes = UserIncomes::getAllUserIncomes($chosenPeriod);

        $expensesUserGroupByCategories = UserExpenses::getUserExpensesGroupByCategories($chosenPeriod);
        $allUseExpenses = UserExpenses::getAllUserExpenses($chosenPeriod);

        View::renderTemplate('Balance/balance.html', [
            'incomesGroupByCategories' => $incomesUserGroupByCategories,
            'allIncomes' => $allUserIncomes,
            'expensesGroupByCategories' => $expensesUserGroupByCategories,
            'allExpenses' => $allUseExpenses,
            'selectPeriod' => $selectPeriod,
            'chosenPeriod' => $chosenPeriod
        ]);
    }
}
