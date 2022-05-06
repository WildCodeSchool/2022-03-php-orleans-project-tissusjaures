<?php

namespace App\Model;

class TutorialManager extends AbstractManager
{
    public const TABLE = 'tutorials';

    public function insert(array $tutorial): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name`, `image`, `content`
        , `tips_and_tricks_categories_id`) 
        VALUES (:name, :image, :content, :tips_and_tricks_categories_id)");
        $statement->bindValue('name', $tutorial['name'], \PDO::PARAM_STR);
        $statement->bindValue('image', $tutorial['image'], \PDO::PARAM_STR);
        $statement->bindValue('content', $tutorial['content'], \PDO::PARAM_STR);
        $statement->bindValue('tips_and_tricks_categories_id', 2, \PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
