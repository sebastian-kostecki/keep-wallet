<?php

namespace App\Models;

use PDO;

class PaymentMethod extends BudgetCategory
{
    protected const NAME_TABLE_WITH_BUDGET_ITEMS_ASSIGNED_TO_USERS = "payment_methods_assigned_to_users";
    protected const NAME_TABLE_WITH_BUDGET_ITEMS = "expenses";
    protected const NAME_COLUMN_WITH_CATEGORY_ASSIGNED_TO_USER_ID = "payment_method_assigned_to_user_id";
    protected const NAME_CATEGORY_WHICH_ASSIGN_BUDGET_ITEMS_FROM_REMOVED_CATEGORY = "Inny";
}
