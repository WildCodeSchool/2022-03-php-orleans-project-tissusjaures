<?php

namespace App\Model;

class HomeMachineManager extends AbstractManager
{
    public const TABLE = 'machines';

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
