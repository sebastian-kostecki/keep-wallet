<?php

namespace App\Models;

use PDO;

abstract class BudgetItem extends \Core\Model
{
    protected const NAME_OF_TABLE_WITH_BUDGET_ITEMS = "";
    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function remove()
    {
        $sql = "DELETE FROM " . self::NAME_OF_TABLE_WITH_BUDGET_ITEMS .
            " WHERE id = :id";

        $db = static::getDataBase();
        $query = $db->prepare($sql);
        $query->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $query->execute();
    }

    protected function isAmountChosen()
    {
        if (!isset($this->amount)) {
            $this->errors[] = 'Brak kwoty';
        }
    }

    protected function isAmountValid()
    {
        $this->amount = filter_var($this->amount, FILTER_VALIDATE_FLOAT);
        if ((!$this->amount) || ($this->amount < 0) || (strlen(substr(strrchr($this->amount, "."), 1)) > 2)) {
            $this->errors[] = 'Kwota jest nieprawidłowa';
        }
    }

    protected function isDateChosen()
    {
        if (!isset($this->date)) {
            $this->errors[] = 'Nie wybrano daty';
        }
    }

    protected function isDateValid()
    {
        $dateArr  = explode('/', $this->date);
        if (count($dateArr) == 3) {
            if (!(checkdate($dateArr[0], $dateArr[1], $dateArr[2]))) {
                $this->errors[]  = 'Data jest nieprawidłowa';
            }
        }
    }

    protected function isPaymentMethodChosen()
    {
        if (!isset($this->paymentMethod)) {
            $this->errors[] = 'Nie wybrano sposobu płatności';
        }
    }

    protected function isCategoryChosen()
    {
        if (!isset($this->category)) {
            $this->errors[] = 'Nie wybrano kategorii';
        }
    }

    protected function isCommentValid()
    {
        if (strlen($this->comment) > 100) {
            $this->errors[]  = 'Komentarz może zawierać maksymalnie 100 znaków';
        }
    }
}
