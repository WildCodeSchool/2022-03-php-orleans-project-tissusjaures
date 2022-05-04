<?php

namespace App\Model;

class ClothManager extends AbstractManager
{
    public const TABLE = 'cloth';

    public function selectAllById(int $id): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT cc.* FROM " . static::TABLE . " cc
          INNER JOIN cloth_categories c ON cc.cloth_categories_id = c.id WHERE cc.id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectOneById(int $id): array|false
    {
        $statement = $this->pdo->prepare("SELECT c.name, c.price, cc.name AS 
        Cat, cc.id AS CatId FROM " . static::TABLE . " AS c INNER JOIN cloth_categories as cc"
        . " ON cc.id = c.cloth_categories_id" . " WHERE c.id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

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
