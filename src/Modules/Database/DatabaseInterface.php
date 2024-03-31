<?php

namespace Modules\Database;

use \PDO;
use Dotenv\Dotenv;

abstract class DatabaseInterface
{
    protected $db;
    protected $host;
    protected $dbname;
    protected $user;
    protected $password;

    // TODO: add table param to all methods

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    abstract public function begin(): void;

    abstract public function rollback(): void;

    abstract public function commit(): void;

    abstract protected function query(string $query, array $params = []);

    public function fetchAll(string $query, array $params = []): array
    {
        $stmt = $this->query($query, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchOne(string $query, array $params = []): mixed
    {
        $stmt = $this->query($query, $params);
        $r = $stmt->fetch(PDO::FETCH_ASSOC) ?: [false];
        return reset($r);
    }

    public function insert(string $table, array $data): bool
    {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $this->query($query, array_values($data));
        return $this->db->lastInsertId();
    }

    public function update(string $table, array $data, string $where)
    {
        $setClause = implode(',', array_map(function ($column, $value) {
            return "$column = ?";
        }, array_keys($data), array_values($data)));
        $query = "UPDATE $table SET $setClause WHERE $where";
        $params = array_values($data);
        $this->query($query, $params);
        return $this->db->rowCount();
    }

    public function delete(string $table, string $where, array $params = []): int
    {
        $query = "DELETE FROM $table WHERE $where";
        $this->query($query, $params);
        return $this->db->rowCount();
    }

    protected function loadEnvVariables()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $this->host = $_ENV['DB_HOST'];
        $this->dbname = $_ENV['MARIADB_DATABASE'];
        $this->user = $_ENV['MARIADB_USER'];
        $this->password = $_ENV['MARIADB_PASSWORD'];
    }
}