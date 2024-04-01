<?php
namespace Modules\App\Parser;

use Modules\Database\Model\Product;
use Modules\Database\Model\KeyWord;
use Modules\App\Json\Json;
use Modules\Database\DB;

class WildberriesParser
{
    private $db;
    private $jsonValidator;
    private $key_word_id;
    private string $url;

    public function __construct(string $key_word, bool $add_key_word = false, )
    {
        if ($key_word === null || $key_word === '') {
            throw new \RuntimeException('Key word is empty');
        }

        $this->key_word_id = KeyWord::getIdByKeyWord($key_word);
        if ($add_key_word === true) {
            $this->key_word_id = KeyWord::add($key_word);
        } else {
            if ($this->key_word_id === null || $this->key_word_id === 0) {
                throw new \RuntimeException('Key word not found');
            }
        }

        $this->formUrl($key_word);
    }

    public function parse(): void
    {
        try {
            $json = $this->fetchJson();
            $this->validateJson($json);
            $this->saveProducts($json);
        } catch (\Exception $e) {
            throw new \RuntimeException('Parse error: ' . $e->getMessage(), 0, $e);
        }
    }

    private function fetchJson(): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);

        return $json;
    }

    private function formUrl(string $key_word): void
    {
        $query = http_build_query([
            'query' => $key_word,
            'ab_testid' => 'pindex',
            'appType' => '1',
            'curr' => 'rub',
            'dest' => '123585979',
            'resultset' => 'catalog',
            'sort' => 'popular',
            'spp' => '30',
            'suppressSpellcheck' => 'false',
            'uclusters' => '1',
            'uiv' => '2',
        ]);
        $this->url = 'https://search.wb.ru/exactmatch/ru/male/v5/search?ab_testid=pindex&appType=1&curr=rub&dest=123585979&' . $query;
    }

    private function validateJson(string $json): void
    {
        if (!Json::isValid($json)) {
            throw new \RuntimeException('Invalid JSON');
        }
    }

    private function saveProducts(string $json): void
    {
        $data = json_decode($json, true);
        $products = $data['data']['products'];

        Product::setPositionZero($this->key_word_id);

        foreach ($products as $key => $product) {
            Product::add(
                $this->key_word_id,
                $key + 1,
                $product['name'] ?? '',
                $product['id'] ?? 0,
            );
        }
    }
}