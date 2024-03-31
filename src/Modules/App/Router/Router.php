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
        $request_uri = $_SERVER['REQUEST_URI'];

        $method = $_SERVER['REQUEST_METHOD'];
        $params = $_GET['search'] ?? '';

        $this->handleRequest($request_uri, $method, $params);
    }

    private function handleRequest($request_uri, $method, $params)
    {
        $uri_parts = explode('/', trim($request_uri, '/'));
        if ($uri_parts[0] === '')
            $uri_parts[0] = '/';

        $handler = $this->routes[$uri_parts[0]] ?? null;
        if ($handler) {
            try {
                $res = call_user_func_array($handler, [$params]);
                http_response_code(200);
                echo Json::encode($res);
            } catch (\Exception $e) {
                http_response_code(404);
                echo Json::encode(array('error' => 'Answer error, ' . $e));
            }

        } else {
            http_response_code(404);
            echo Json::encode(array('error' => 'Not Found'));
        }
    }
}