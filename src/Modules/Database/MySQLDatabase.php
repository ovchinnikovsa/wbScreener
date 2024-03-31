<?php

namespace Modules\Database;

use \PDO;
use \PDOException;
use \Modules\Database\DatabaseInterface;

class MySQLDatabase extends DatabaseInterface
{
    public function __construct()
    {
        $this->loadEnvVariables();

        try {
            $this->db = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function begin(): void
    {
        $this->db->beginTransaction();
    }

    public function rollback(): void
    {
        $this->db->rollBack();
    }

    public function commit(): void
    {
        $this->db->commit();
    }


    protected function query($sql, $params = [])
    {

        $stmt = $this->db->prepare($sql . ';');
        $stmt->execute($params);
        return $stmt;
    }

}