<?php

namespace App\Model;

class ClothCategoryManager extends AbstractManager
{
    public const TABLE = 'cloth_categories';

    public function insert(array $clothCategory): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name`, `image`) 
        VALUES (:name, :image)");
        $statement->bindValue('name', $clothCategory['name'], \PDO::PARAM_STR);
        $statement->bindValue('image', '/uploads/' . $clothCategory['image'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $clothCategory): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `name` = :name, `image` = :image
        WHERE `id` = :id");
        $statement->bindValue('id', $clothCategory['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $clothCategory['name'], \PDO::PARAM_STR);
        $statement->bindValue('image', '/uploads/' . $clothCategory['image'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
