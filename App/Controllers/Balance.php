<?php

namespace App\Controllers;

use Core\View;

class Balance extends Authenticated
{
    public function currentMonthAction()
    {
        $currentMonth = $_POST['currentMonth'];
        $firstDay = substr($currentMonth, 0, 10);
        $lastDay = substr($currentMonth, 11);

        //trzeba pobrać:
            //kategorie do wyświetlenia raze z sumami ich wartości
            //wszystkie wydatki i przychody
            //sumę wszystkich wydatków oraz przychodów

        View::renderTemplate('Balance/currentMonth.html');
    }
}
