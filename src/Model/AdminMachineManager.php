<?php

namespace App\Model;

class AdminMachineManager extends AbstractManager
{
    public const TABLE = 'machine';

    public function insert(array $machine): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name`, `price`, 
        `description`) 
        VALUES (:name, :price, :description)");
        $statement->bindValue('name', $machine['name'], \PDO::PARAM_STR);
        $statement->bindValue('price', $machine['price'], \PDO::PARAM_STR);
        $statement->bindValue('description', $machine['description'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
