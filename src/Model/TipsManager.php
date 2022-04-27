<?php

namespace App\Model;

class TipsManager extends AbstractManager
{
    public const TABLE = 'tutorials';

    public function selectByIsMonthlyTip(): array
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE is_monthly_tip");
        $statement->execute();

        return $statement->fetchAll();
    }
}
