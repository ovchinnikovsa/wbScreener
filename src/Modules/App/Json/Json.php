<?php

namespace Modules\App\Json;

class Json
{
    public static function encode($data): string
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public static function isValid(string $json): bool
    {
        return json_last_error() === JSON_ERROR_NONE && json_decode($json) !== null;
    }

    public static function decode(string $json): array
    {
        return json_decode($json, true);
    }

    public static function send(array $data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        if (empty($data))
            $data = ['no data'];
        echo self::encode($data);
        die();
    }
}