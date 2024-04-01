<?php

declare(strict_types=1);
// error_reporting(0);
// session_start();

require_once __DIR__ . '/vendor/autoload.php';

use Modules\App\Router\Router;
use Modules\App\Api\ProductAPI;
use Modules\App\View\View;

$router = new Router();

$router->addRoute('/', [View::class, 'tryApi']);
$router->addRoute('getProducts', [ProductAPI::class, 'getProducts']);
$router->addRoute('getNewProducts', [ProductAPI::class, 'getNewProducts']);
$router->addRoute('getArticle', [ProductAPI::class, 'getArticle']);

$router->sendResponse();
