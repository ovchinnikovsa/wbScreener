<?php

namespace Modules\Database;

use \PDO;

/**
 * @deprecated use MySQLDatabase
 */
class SQLiteDatabase extends DatabaseInterface
{
    private $db;
    private static $db_path = '/var/www/db/database.db';

    public function __construct()
    {
        $this->db = new PDO('sqlite:' . self::$db_path);
    }

    protected function query(string $query, array $params = [])
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

}