<?php

namespace App\Model;

class TipsManager extends AbstractManager
{
    public const TABLE = 'tips';

    public function selectMonthlyTip(): array|false
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE is_monthly_tip = 1");
        $statement->execute();

        return $statement->fetch();
    }
}
