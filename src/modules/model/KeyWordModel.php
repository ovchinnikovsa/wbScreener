<?php

namespace modules\classes\model;

use modules\classes\database\DatabaseFacade;


class KeyWordModel
{
    private static string $tableName = 'key_word';

    public static function getAll()
    {
        $query = 'SELECT * FROM ' . self::$tableName;
        return DatabaseFacade::fetchAll($query);
    }

    public function getById(int $id)
    {
        $query = "SELECT * FROM " . self::$tableName . " WHERE id = ?";
        return DatabaseFacade::fetchOne($query, [$id]);
    }

    public static function create(string $key_word): bool
    {
        if (empty($key_word)) {
            return false;
        }

        return DatabaseFacade::insert(self::$tableName, [
            'word' => $key_word,
        ]);
    }

    public function update(int $id, array $data)
    {
        $where = 'id = ?';
        return DatabaseFacade::update(self::$tableName, $data, $where);
    }

    public function delete(int $id)
    {
        $where = 'id = ?';
        $params = [$id];
        return DatabaseFacade::delete(self::$tableName, $where, $params);
    }
}