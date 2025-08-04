<?php

namespace src\infra\database\mappers;

abstract class Mapper
{
    protected static function extractPrefixed(array $data, string $prefix): array
    {
        $prefixLength = strlen($prefix) + 1;
        $filtered = [];

        foreach ($data as $key => $value) {
            if (str_starts_with($key, $prefix . '_')) {
                $filtered[substr($key, $prefixLength)] = $value;
            }
        }

        return $filtered;
    }

    protected static function getValuesWithPrefix(array $data, string $prefix): array
    {
        $filtered = [];
        foreach ($data as $key => $value) {
            if (str_starts_with($key, $prefix . '_')) {
                $filtered[$key] = $value;
            }
        }
        return $filtered;
    }
}

?>