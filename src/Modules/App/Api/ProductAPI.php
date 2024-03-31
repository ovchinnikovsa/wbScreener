<?php

namespace Modules\App\Api;

use Modules\App\Parser\WildberriesParser;
use Modules\Database\Model\KeyWord;
use Modules\Database\Model\Product;

class ProductAPI
{
    public static function getProducts(string $search)
    {
        $key_word_id = KeyWord::getIdByKeyWord($search);
        return Product::getRowByKeyWord($key_word_id);
    }

    public static function getNewProducts(string $search)
    {
        $wp = new WildberriesParser($search, add_key_word: true);
        $wp->parse();
        $key_word_id = KeyWord::getIdByKeyWord($search);
        return Product::getRowByKeyWord($key_word_id);
    }

    public static function getArticle($article_id)
    {
        return Product::getActiveRowsByArticle($article_id);
    }

}