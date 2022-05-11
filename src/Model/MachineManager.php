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

    public function insert(array $machine): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name`, `price`, `image`, 
        `description`, `is_on_sale`, `is_new`) 
        VALUES (:name, :price, :image, :description, :is_on_sale, :is_new)");
        $statement->bindValue('name', $machine['name'], \PDO::PARAM_STR);
        $statement->bindValue('price', $machine['price'], \PDO::PARAM_STR);
        $statement->bindValue('image', '/uploads/' . $machine['image'], \PDO::PARAM_STR);
        $statement->bindValue('description', $machine['description'], \PDO::PARAM_STR);
        $statement->bindValue('is_on_sale', $machine['is_on_sale'] ?? 0, \PDO::PARAM_INT);
        $statement->bindValue('is_new', $machine['is_new'] ?? 0, \PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $machine): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `name` = :name, `image` = :image, 
        `price` = :price, `description` = :description, `is_on_sale` = :is_on_sale, `is_new` = :is_new WHERE id=:id");
        $statement->bindValue('id', $machine['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $machine['name'], \PDO::PARAM_STR);
        $statement->bindValue('image', '/uploads/' . $machine['image'], \PDO::PARAM_STR);
        $statement->bindValue('price', $machine['price'], \PDO::PARAM_STR);
        $statement->bindValue('description', $machine['description'], \PDO::PARAM_STR);
        $statement->bindValue('is_on_sale', $machine['is_on_sale'] ?? 0, \PDO::PARAM_INT);
        $statement->bindValue('is_new', $machine['is_new'] ?? 0, \PDO::PARAM_INT);

        return $statement->execute();
    }

    public function selectByIsNew(): array
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE is_new");
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectBySearch(string $search): array|false
    {
        $statement = $this->pdo->prepare("SELECT m.name, m.price, m.description, m.image
        FROM " . static::TABLE . " m WHERE m.name LIKE :search");
        $statement->bindValue('search', '%' . $search . '%');
        $statement->execute();

        return $statement->fetchAll();
    }
}
