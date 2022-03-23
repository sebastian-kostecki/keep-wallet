<?php

namespace App\Controllers;

use Core\View;

class Balance extends Authenticated
{
    public function currentMonthAction()
    {
        View::renderTemplate('Balance/currentMonth.html');
    }
}
