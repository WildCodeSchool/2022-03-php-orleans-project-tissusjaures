<?php

namespace App\Model;

class AdminMachineManager extends AbstractManager
{
    public const TABLE = 'machines';

    public function selectOneById(int $id): array|false
    {
        $statement = $this->pdo->prepare("SELECT m.name, m.price, m.description FROM " . static::TABLE . " AS m" . " WHERE m.id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

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
        `description` = :description, WHERE id=:id");
        $statement->bindValue('id', $machine['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $machine['name'], \PDO::PARAM_STR);
        $statement->bindValue('price', $machine['price'], \PDO::PARAM_STR);
        $statement->bindValue('description', $machine['description'], \PDO::PARAM_INT);

        return $statement->execute();
    }
}
