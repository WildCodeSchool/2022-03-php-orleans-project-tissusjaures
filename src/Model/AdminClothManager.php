<?php

namespace App\Model;

class AdminClothManager extends AbstractManager
{
    public const TABLE = 'cloth';

    /**
     * Insert new item in database
     */
    public function insert(array $cloth): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name`, `price`, 
        `cloth_categories_id`) 
        VALUES (:name, :price, :cloth_categories_id)");
        $statement->bindValue('name', $cloth['name'], \PDO::PARAM_STR);
        $statement->bindValue('price', $cloth['price'], \PDO::PARAM_STR);
        $statement->bindValue('cloth_categories_id', $cloth['cloth_categories_id'], \PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Update item in database
     */
    public function update(array $cloth): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `name` = :name, `price` = :price, 
        `cloth_categories_id` = :cloth_categories_id WHERE id=:id");
        $statement->bindValue('id', $cloth['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $cloth['name'], \PDO::PARAM_STR);
        $statement->bindValue('price', $cloth['price'], \PDO::PARAM_STR);
        $statement->bindValue('cloth_categories_id', $cloth['cloth_categories_id'], \PDO::PARAM_INT);

        return $statement->execute();
    }
}
