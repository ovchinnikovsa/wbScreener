<?php

namespace Modules\App\Api;

use Modules\App\Parser\WildberriesParser;
use Modules\Database\Model\KeyWord;
use Modules\Database\Model\Product;

class ProductAPI
{
    public static function getProducts(array $param)
    {
        $search_query = self::checkSearchQuery($param);
        $key_word_id = KeyWord::getIdByKeyWord($search_query);
        return Product::getRowByKeyWord($key_word_id);
    }

    public static function getNewProducts(array $param)
    {
        $search_query = self::checkSearchQuery($param);
        $wp = new WildberriesParser($search_query, add_key_word: true);
        $wp->parse();
        $key_word_id = KeyWord::getIdByKeyWord($search_query);
        return Product::getRowByKeyWord($key_word_id);
    }

    public static function getArticle(array $param)
    {
        $article = self::checkArticle($param);
        $res = Product::getActiveRowsByArticle($article);
        foreach ($res as &$value) {
            $key_word = KeyWord::getById($value['key_word_id']);
            unset($value['key_word_id']);
            $value['key_word'] = $key_word;
        }
        return $res;
    }

    private static function checkArticle(array $param): int
    {
        $param = (int) ($_GET['article'] ?? false);
        if ($param <= 0) {
            throw new \Exception("Wrong article param", 1);
        }
        return $param;
    }
    private static function checkSearchQuery(array $param): string
    {
        $param = (string) ($_GET['search_query'] ?? false);
        if (!$param) {
            throw new \Exception("Wrong search_query param", 1);
        }
        return $param;
    }
}