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
        $statement->bindValue('image', $clothCategory['image'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
