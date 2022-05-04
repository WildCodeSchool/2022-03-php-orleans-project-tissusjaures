<?php

namespace App\Model;

class AdminLexiconManager extends AbstractManager
{
    public const TABLE = 'lexicon';

    public function insert(array $lexicon): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name`,
        `description`) 
        VALUES (:name, :description)");
        $statement->bindValue('name', $lexicon['name'], \PDO::PARAM_STR);
        $statement->bindValue('description', $lexicon['description'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
