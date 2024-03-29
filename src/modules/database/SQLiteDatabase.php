<?php

namespace modules\classes\database;

use \PDO;

class SQLiteDatabase
{
    private $db;
    private static $db_path = '/var/www/html/database.db';

    public function __construct()
    {
        $this->db = new PDO('sqlite:' . self::$db_path);
    }

    private function executeQuery(string $query, array $params = [])
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchAll(string $query, array $params = []): array
    {
        $stmt = $this->executeQuery($query, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchOne(string $query, array $params = []): mixed
    {
        $stmt = $this->executeQuery($query, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert(string $table, array $data): bool
    {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $this->executeQuery($query, array_values($data));
        return $this->db->lastInsertId();
    }

    public function update(string $table, array $data, string $where)
    {
        $setClause = implode(',', array_map(function ($column, $value) {
            return "$column = ?";
        }, array_keys($data), array_values($data)));
        $query = "UPDATE $table SET $setClause WHERE $where";
        $params = array_values($data);
        $this->executeQuery($query, $params);
        return $this->db->rowCount();
    }

    public function delete(string $table, string $where, array $params = [])
    {
        $query = "DELETE FROM $table WHERE $where";
        $this->executeQuery($query, $params);
        return $this->db->rowCount();
    }
}