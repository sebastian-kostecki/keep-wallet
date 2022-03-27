<?php

namespace App\Models;

abstract class UserBudgetItems extends \Core\Model
{
    public static function getfirstDayOfPeriod()
    {
        return substr($_SESSION['chosenPeriod'], 0, 10);
    }

    public static function getLastDayOfPeriod()
    {
        return substr($_SESSION['chosenPeriod'], 11);
    }
}
