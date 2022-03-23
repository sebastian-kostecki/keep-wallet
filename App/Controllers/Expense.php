<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\ExpenseCategory;

class Expense extends \Core\Controller
{
    public function newAction()
    {
        $user = User::findByID($_SESSION['userId']);
        $userExpenseCategories = ExpenseCategory::findCategories($user);
    }
}
