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
        //View::renderTemplate('Balance/currentMonth.html');
    }
}
