<?php

namespace App\Model;

class HomeClothManager extends AbstractManager
{
    public const TABLE = 'cloth';

        /**
     * Get one row from database by isNew.
     */
    public function selectByIsNew(): array
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE is_new");
        $statement->execute();

        return $statement->fetchAll();
    }
}
