<?php

namespace App\Controllers;

use App\Models\Expenditure;
use App\Models\Incomes;
use App\Models\Revenue;
use Core\View;
use App\Models\User;

class Balance extends Authenticated
{
    public function currentMonthAction()
    {
        $currentMonth = $_POST['currentMonth'];
        $incomes = Revenue::fetchIncomes($currentMonth);
        $expenses = Expenditure::fetchExpenses($currentMonth);

        View::renderTemplate('Balance/balance.html', [
            'incomes' => $incomes,
            'expenses' => $expenses
        ]);
    }

    public function selectAction()
    {
        $period = $_POST['balancePeriod'];
        $incomes = Revenue::fetchIncomes($period);
        $expenses = Expenditure::fetchExpenses($period);
        View::renderTemplate('Balance/balance.html', [
            'incomes' => $incomes,
            'expenses' => $expenses
        ]);
    }
}
