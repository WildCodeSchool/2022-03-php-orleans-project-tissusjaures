<?php

namespace App\Model;

class TipManager extends AbstractManager
{
    public const TABLE = 'tips';

    public function selectMonthlyTip(): array|false
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE is_monthly_tip = 1");
        $statement->execute();

        return $statement->fetch();
    }

    public function selectTips(): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE is_monthly_tip = 0");
        $statement->execute();

        return $statement->fetchAll();
    }

    public function insert(array $tip): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name`, `image`, `content`
        , `is_monthly_tip`, `tips_and_tricks_categories_id`) 
        VALUES (:name, :image, :content, :is_monthly_tip, :tips_and_tricks_categories_id)");
        $statement->bindValue('name', $tip['name'], \PDO::PARAM_STR);
        $statement->bindValue('image', '/uploads/' . $tip['image'], \PDO::PARAM_STR);
        $statement->bindValue('content', $tip['content'], \PDO::PARAM_STR);
        $statement->bindValue('is_monthly_tip', $tip['is_monthly_tip'] ?? 0, \PDO::PARAM_INT);
        $statement->bindValue('tips_and_tricks_categories_id', 1, \PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $tip): int
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `name` = :name, `image` = :image
        , `content` = :content, `is_monthly_tip` = :is_monthly_tip
        , `tips_and_tricks_categories_id` = :tips_and_tricks_categories_id
        WHERE `id` = :id");
        $statement->bindValue('name', $tip['name'], \PDO::PARAM_STR);
        $statement->bindValue('id', $tip['id'], \PDO::PARAM_INT);
        $statement->bindValue('image', '/uploads/' . $tip['image'], \PDO::PARAM_STR);
        $statement->bindValue('content', $tip['content'], \PDO::PARAM_STR);
        $statement->bindValue('is_monthly_tip', $tip['is_monthly_tip'] ?? 0, \PDO::PARAM_INT);
        $statement->bindValue('tips_and_tricks_categories_id', 1, \PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
