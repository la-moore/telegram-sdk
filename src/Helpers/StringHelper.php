<?php

namespace LaMoore\Tg\Helpers;

class StringHelper
{
    static function replace(string $str, array $data = []): string{
        $matches = array_map(fn ($key) => "$$key", array_keys($data));

        return str_replace($matches, array_values($data), $str);
    }
}