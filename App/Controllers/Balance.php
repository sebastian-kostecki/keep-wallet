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

        //trzeba pobrać:
        //kategorie do wyświetlenia raze z sumami ich wartości
        //wszystkie wydatki i przychody
        //sumę wszystkich wydatków oraz przychodów

        View::renderTemplate('Balance/currentMonth.html', [
            'incomes' => $incomes,
            'expenses' => $expenses
        ]);
    }
}
