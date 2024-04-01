<?php

namespace Modules\Database\Model;

use Modules\Database\DB;


class KeyWord
{
    private static string $tableName = 'key_word';

    public static function getAll()
    {
        $query = 'SELECT * FROM ' . self::$tableName;
        return DB::fetchAll($query);
    }

    public static function add(string $key_word): int
    {
        if (empty($key_word)) {
            throw new \Exception("Error: empty key word", 1);
        }

        $id = self::getIdByKeyWord($key_word);
        if ($id > 0) {
            return $id;
        }

        return (int) DB::insert(self::$tableName, [
            'word' => $key_word,
        ]);
    }

    public static function getIdByKeyWord(string $key_word): int
    {
        $id = DB::fetchOne("SELECT id FROM
        " . self::$tableName . " WHERE word = ?", [$key_word]);
        return (int) $id ?? 0;
    }

    public static function getById(int $id): string
    {
        $key_word = DB::fetchOne("SELECT word FROM
        " . self::$tableName . " WHERE id = ?", [$id]);
        return (string) $key_word ?? '';
    }

    public function delete(int $id)
    {
        $where = 'id = ?';
        $params = [$id];
        return DB::delete(self::$tableName, $where, $params);
    }
}