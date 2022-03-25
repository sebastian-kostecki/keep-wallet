<?php

namespace App\Controllers;

use App\Models\Expenditure;
use App\Models\Incomes;
use App\Models\Revenue;
use Core\View;
use App\Models\User;

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
