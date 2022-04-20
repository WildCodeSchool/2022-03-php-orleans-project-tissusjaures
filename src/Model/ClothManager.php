<?php

namespace App\Model;

class ClothManager extends AbstractManager
{
    public const TABLE = 'cloth';

    /**
     * Insert new item in database
     */
    public function insert(array $cloth): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name`) VALUES (:name)");
        $statement->bindValue('name', $cloth['name'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Update item in database
     */
    public function update(array $item): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `name` = :name WHERE id=:id");
        $statement->bindValue('id', $item['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $item['name'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
