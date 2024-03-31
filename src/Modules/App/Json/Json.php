<?php

namespace Modules\App\Json;

class Json
{
    public static function encode($data): string
    {
        return json_encode($data);
    }

    public static function isValid(string $json): bool
    {
        return json_last_error() === JSON_ERROR_NONE && json_decode($json) !== null;
    }
}