<?php

namespace App\Models;

class IncomeCategory extends BudgetCategory
{
    protected const NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS = "incomes_category_assigned_to_users";
    protected const NAME_TABLE_WITH_BUDGET_ITEMS = "incomes";
    protected const NAME_COLUMN_WITH_CATEGORY_ASSIGNED_TO_USER_ID = "income_category_assigned_to_user_id";
    protected const NAME_CATEGORY_WHICH_ASSIGN_BUDGET_ITEMS_FROM_REMOVED_CATEGORY = "Inne przychody";
}
