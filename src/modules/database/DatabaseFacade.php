<?php

namespace modules\classes\database;

use modules\classes\database\SQLiteDatabase;

class DatabaseFacade
{
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!self::$instance instanceof SQLiteDatabase) {
            self::$instance = new SQLiteDatabase();
        }
        return self::$instance;
    }

    public static function executeQuery(string $query, array $params = [])
    {
        $instance = self::getInstance();
        try {
            $stmt = $instance->executeQuery($query, $params);
        } catch (\PDOException $e) {
            throw new \PDOException('Database query execution error', 0, $e);
        }
        return $stmt;
    }

    public static function fetchAll( string $query, array $params = [])
    {
        $instance = self::getInstance();
        try {
            $stmt = $instance->fetchAll($query, $params);
        } catch (\PDOException $e) {
            throw new \PDOException('Database query execution error', 0, $e);
        }
        return $stmt;
    }

    public static function fetchOne(string $query, array $params = [])
    {
        $instance = self::getInstance();
        try {
            $stmt = $instance->fetchOne($query, $params);
        } catch (\PDOException $e) {
            throw new \PDOException('Database query execution error', 0, $e);
        }
        return $stmt;
    }

    public static function insert(string $table, array $data)
    {
        $instance = self::getInstance();
        try {
            $id = $instance->insert($table, $data);
        } catch (\PDOException $e) {
            throw new \PDOException('Database insert error', 0, $e);
        }
        return $id;
    }

    public static function update(string $table, array $data, string $where)
    {
        $instance = self::getInstance();
        try {
            $count = $instance->update($table, $data, $where);
        } catch (\PDOException $e) {
            throw new \PDOException('Database update error', 0, $e);
        }
        return $count;
    }

    public static function delete(string $table, string  $where, array $params = [])
    {
        $instance = self::getInstance();
        try {
            $count = $instance->delete($table, $where, $params);
        } catch (\PDOException $e) {
            throw new \PDOException('Database delete error', 0, $e);
        }
        return $count;
    }
}
