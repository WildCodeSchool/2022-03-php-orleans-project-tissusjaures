<?php

namespace App\Model;

class MachineManager extends AbstractManager
{
    public const TABLE = 'machines';

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

    public function update(array $machine): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `name` = :name, `price` = :price, 
        `description` = :description WHERE id=:id");
        $statement->bindValue('id', $machine['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $machine['name'], \PDO::PARAM_STR);
        $statement->bindValue('price', $machine['price'], \PDO::PARAM_STR);
        $statement->bindValue('description', $machine['description'], \PDO::PARAM_STR);

        return $statement->execute();
    }

    public function selectByIsNew(): array
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE is_new");
        $statement->execute();

        return $statement->fetchAll();
    }
}
