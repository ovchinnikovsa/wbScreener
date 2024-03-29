<?php

declare(strict_types=1);
// error_reporting(0);
// session_start();

require_once __DIR__ . '/vendor/autoload.php';

use modules\classes\model\ProductModel;

echo 'Hello! <pre>';

echo '<br>';
echo '<br>';
echo '<br>';


$ch = curl_init();
$key_word = http_build_query(['query' => 'черная футболка']);

$res = ProductModel::create('черная футболка', 1, 'черная футболка name', 123132513);

var_dump($res);
die();

var_dump($key_word);

$url = 'https://search.wb.ru/exactmatch/ru/male/v5/search?ab_testid=pindex&appType=1&curr=rub&dest=123585979&' . $key_word . '&resultset=catalog&sort=popular&spp=30&suppressSpellcheck=false&uclusters=1&uiv=2&uv=KIisQKx3KPqrQq65pECuQDFCrGQuryzQreEpQq2MKh8wOSMSrUSx9KjNL2Whgi-yLvAi5qY7K6aplyufMX0oda7DHiYuNinqqskjWqW9rHulzK2sLXssI6tmIcUuj7HOLB4wwq2vKVwwpSfNK8YqN6pQMHCvfS6PsiWuLy4rMDIu2KqCLsOqVq2rMRwoxa_Xqc0rgS6arcuu8KZWLUmt-6_8rZQwxyyFGv-eT7DHJeovrbGkqZWrT7ASrK-wUqtMKFUwDilwK3Wcuq0tKE6pabAmo3WomqYCKYYp8axJINsxF7DGqdIoLS51KnYsyq5JFm0tDCxUJ9oZ0LCnrYKgxw';
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);
$data = json_decode($response, true);
$products = $data['data']['products'] ?? [];

foreach ($products as $key => $item) {
    echo $key . ' ' . ($item['name'] ?? 'no name') . ' ' . (string) ($item['id'] ?? 'no id') . ' ' . PHP_EOL;
    echo '<br>';
    ProductModel::create('черная футболка', $key, $item['name'] ?? '', $item['id'] ?? 0);
    echo '<br>';
    echo '<br>';
}

// https://search.wb.ru/exactmatch/ru/male/v5/search?ab_testid=pindex&appType=1&curr=rub&dest=123585979&query=%D1%87%D1%91%D1%80%D0%BD%D0%B0%D1%8F%20%D1%84%D1%83%D1%82%D0%B1%D0%BE%D0%BB%D0%BA%D0%B0&resultset=catalog&sort=popular&spp=30&suppressSpellcheck=false&uclusters=1&uiv=2&uv=KIisQKx3KPqrQq65pECuQDFCrGQuryzQreEpQq2MKh8wOSMSrUSx9KjNL2Whgi-yLvAi5qY7K6aplyufMX0oda7DHiYuNinqqskjWqW9rHulzK2sLXssI6tmIcUuj7HOLB4wwq2vKVwwpSfNK8YqN6pQMHCvfS6PsiWuLy4rMDIu2KqCLsOqVq2rMRwoxa_Xqc0rgS6arcuu8KZWLUmt-6_8rZQwxyyFGv-eT7DHJeovrbGkqZWrT7ASrK-wUqtMKFUwDilwK3Wcuq0tKE6pabAmo3WomqYCKYYp8axJINsxF7DGqdIoLS51KnYsyq5JFm0tDCxUJ9oZ0LCnrYKgxw
