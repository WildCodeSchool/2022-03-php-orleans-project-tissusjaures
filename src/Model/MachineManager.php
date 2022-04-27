<?php

namespace App\Model;

class MachineManager extends AbstractManager
{
    public const TABLE = 'machine';

    public function insert(array $machine): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`title`) VALUES (:title)");
        $statement->bindValue('title', $machine['title'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $machine): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $machine['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $machine['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
