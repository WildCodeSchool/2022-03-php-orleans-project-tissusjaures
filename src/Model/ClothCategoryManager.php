<?php

namespace App\Model;

class ClothCategoryManager extends AbstractManager
{
    public const TABLE = 'cloth_categories';

    // public function update(array $clothCategory): bool
    // {
    //     $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `name` = :name, `price` = :price, 
    //     `cloth_categories_id` = :cloth_categories_id WHERE id=:id");
    //     $statement->bindValue('id', $clothCategory['id'], \PDO::PARAM_INT);
    //     $statement->bindValue('name', $clothCategory['name'], \PDO::PARAM_STR);
    //     $statement->bindValue('image', $clothCategory['price'], \PDO::PARAM_STR);

    //     return $statement->execute();
    // }
}
