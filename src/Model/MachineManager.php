<?php

namespace App\Model;

class MachineManager extends AbstractManager
{
    public const TABLE = 'machines';

    public function selectAllById(int $id): array|false
    {
        $statement = $this->pdo->prepare("SELECT m.* FROM " . static::TABLE . " m
          INNER JOIN machine_categories mc ON m.machine_categories_id = mc.id WHERE m.id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
