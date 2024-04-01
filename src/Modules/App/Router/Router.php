<?php

namespace Modules\App\Router;

use Modules\App\Json\Json;

class Router
{
    private $routes = [];

    public function addRoute($uri, $handler)
    {
        $this->routes[$uri] = $handler;
    }

    public function sendResponse()
    {
        $query = self::getParsedQuery();
        $this->handleRequest($query['method'], $query['params']);
    }

    private function handleRequest($method, $params)
    {

        $handler = $this->routes[$method] ?? null;
        if ($handler) {
            try {
                $res = call_user_func_array($handler, [$params]);
                Json::send($res);
            } catch (\Exception $e) {
                Json::send([
                    'error' => 'Answer error',
                    'message' => $e->getMessage()
                ], 404);
            }
        } else {
            Json::send([
                'error' => 'Not Found'
            ], 404);
        }
    }

    private static function getCurrentUrl(): string
    {
        $url = empty($_SERVER['HTTPS']) ? 'http' : 'https';
        $url .= "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $url;
    }

    private static function getParsedQuery(): array
    {
        $url = parse_url(self::getCurrentUrl());

        $method = $url['path'] ?? '';
        $method = explode('/', $method);
        $method = $method[0] ?: $method[1];
        $method = $method === '' ? '/' : $method;

        $url_params = $url['query'] ?? '';
        $url_params = urldecode($url_params);
        parse_str($url_params, $params);

        return [
            'method' => $method,
            'params' => $params,
        ];
    }
}