<?php

namespace Modules\Database\Model;

use Modules\Database\DB;

class Product
{

    private static string $tableName = 'products';

    public static function getAll()
    {
        $query = 'SELECT * FROM ' . self::$tableName;
        return DB::fetchAll($query);
    }

    public static function getById(int $id)
    {
        $query = "SELECT * FROM " . self::$tableName . " WHERE id = ?";
        return DB::fetchOne($query, [$id]);
    }

    public static function add(int $key_word_id, int $position, string $name, int $product_article): bool
    {
        if (empty($key_word_id) || empty($position) || empty($name) || empty($product_article)) {
            return false;
        }

        $id = self::getRowByArticleAndKeyWord($product_article, $key_word_id);
        if ($id) {
            return self::update($id, [
                'position' => $position,
                'name' => $name,
            ]);
        }

        return DB::insert(self::$tableName, [
            'key_word_id' => $key_word_id,
            'position' => $position,
            'name' => $name,
            'product_article' => $product_article
        ]);
    }

    public static function update(int $id, array $data)
    {
        $where = 'id = ?';
        return DB::update(self::$tableName, $data, $where);
    }

    public static function delete(int $id)
    {
        $where = 'id = ?';
        $params = [$id];
        return DB::delete(self::$tableName, $where, $params);
    }

    public static function getActiveRowsByArticle(int $article): array
    {
        $query = 'SELECT * FROM ' . self::$tableName . ' WHERE `article` = ? AND `position` <> ?';
        $params = [
            'article' => $article,
            'position' => 0,
        ];
        return DB::fetchAll($query, $params);
    }

    public static function setPositionZero(int $key_word_id): array
    {
        $where = 'key_word_id = ?';
        return DB::update(self::$tableName, [
            'key_word_id' =>
                $key_word_id
        ], $where);
    }

    public static function getRowByArticleAndKeyWord(int $article, int $key_word_id): int
    {
        $query = "SELECT `id` FROM " . self::$tableName . " WHERE `article` = ? AND `key_word_id` = ?  AND `position` <> ?";
        return DB::fetchOne($query, [
            'article' => $article,
            'key_word_id' => $key_word_id,
            'position' => 0,
        ]);
    }

    public static function getRowByKeyWord(int $key_word_id): int
    {
        $query = "SELECT `id` FROM " . self::$tableName . " WHERE `key_word_id` = ?  AND `position` <> ?";
        return DB::fetchOne($query, [
            'key_word_id' => $key_word_id,
            'position' => 0,
        ]);
    }
}