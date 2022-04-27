<?php

namespace App\Model;

class TipsManager extends AbstractManager
{
    public const TABLE = 'tips';

    public function selectByIsMonthlyTip(): array
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE is_monthly_tip = 1");
        $statement->execute();

        return $statement->fetchAll();
    }
}
