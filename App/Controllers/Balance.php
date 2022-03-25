<?php

namespace App\Controllers;

use App\Models\Expenditure;
use App\Models\Revenue;
use Core\View;

class Balance extends Authenticated
{
    public function showAction()
    {
        $chosenPeriod = $_POST['chosenPeriod'];
        $selectPeriod = $_POST['selectPeriod'];

        $incomes = Revenue::fetchIncomes($chosenPeriod);
        $expenses = Expenditure::fetchExpenses($chosenPeriod);

        View::renderTemplate('Balance/balance.html', [
            'incomes' => $incomes,
            'expenses' => $expenses,
            'selectPeriod' => $selectPeriod,
            'chosenPeriod' => $chosenPeriod
        ]);
    }
}
