<?php

namespace modules\classes\model;

use modules\classes\database\DatabaseFacade;

class ProductModel
{

    // TODO: add uniq option at position
    private static string $tableName = 'products';

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

    public static function create(string $key_word, int $position, string $name, int $product_article): bool
    {
        if (empty($key_word) || empty($position) || empty($name) || empty($product_article)) {
            return false;
        }

        return DatabaseFacade::insert(self::$tableName, [
            'key_word' => $key_word,
            'position' => $position,
            'name' => $name,
            'product_article' => $product_article
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