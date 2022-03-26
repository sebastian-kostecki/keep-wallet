<?php

namespace App\Controllers;

use App\Models\Expenditure;
use App\Models\Revenue;
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

        $incomes = Revenue::fetchIncomes($chosenPeriod);
        $expenses = Expenditure::fetchExpenses($chosenPeriod);

        View::renderTemplate('Balance/balance.html', [
            'incomesGroupByCategories' => $incomesUserGroupByCategories,
            'allUserIncomes' => $allUserIncomes,
            'expenses' => $expenses,
            'selectPeriod' => $selectPeriod,
            'chosenPeriod' => $chosenPeriod
        ]);
    }
}
