<?php

namespace App\Model;

class LexiconManager extends AbstractManager
{
    public const TABLE = 'lexicon';

    public function insert(array $lexicon): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name`,
        `definition`) 
        VALUES (:name, :definition)");
        $statement->bindValue('name', $lexicon['name'], \PDO::PARAM_STR);
        $statement->bindValue('definition', $lexicon['definition'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $lexicon): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `name` = :name,
        `definition` = :definition WHERE id=:id");
        $statement->bindValue('id', $lexicon['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $lexicon['name'], \PDO::PARAM_STR);
        $statement->bindValue('definition', $lexicon['definition'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
