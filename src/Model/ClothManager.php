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
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name`, `price`, 
        `image`, `is_on_sale`, `is_new`, `cloth_categories_id`) 
        VALUES (:name, :price, :image, :is_on_sale, :is_new, :cloth_categories_id)");
        $statement->bindValue('name', $cloth['name'], \PDO::PARAM_STR);
        $statement->bindValue('price', $cloth['price'], \PDO::PARAM_STR);
        $statement->bindValue('image', $cloth['image'], \PDO::PARAM_STR);
        $statement->bindValue('is_on_sale', $cloth['is_on_sale'], \PDO::PARAM_BOOL);
        $statement->bindValue('is_new', $cloth['is_new'], \PDO::PARAM_BOOL);
        $statement->bindValue('cloth_categories_id', $cloth['cloth_categories_id'], \PDO::PARAM_INT);

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
