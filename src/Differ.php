<?php

namespace Differ\Differ;

use function Functional\sort;

function genDiff(string $filePath1, string $filePath2)
{
    $fileData1 = json_decode(file_get_contents($filePath1), true); // читаем файл, декодируем в массив
    $fileData2 = json_decode(file_get_contents($filePath2), true);

    $keys = array_unique(array_merge(array_keys($fileData1), array_keys($fileData2))); //находим все ключи

    $sortedKeys = sort($keys, fn ($left, $right) => strcmp($left, $right)); // сортируем ключи по алфавиту

    //print_r ($sortedKeys);
    $diff = array_map(function ($key) use ($fileData1, $fileData2) {
        if (array_key_exists($key, $fileData1) && array_key_exists($key, $fileData2)) {
            if ($fileData1[$key] === $fileData2[$key]) {
                return "  $key: " . var_export($fileData1[$key], true);
            } else {
                return "- $key: " . $fileData1[$key] . "\n+ $key: " . $fileData2[$key];
            }
        } elseif (array_key_exists($key, $fileData1)) {
            return "- $key: " . var_export($fileData1[$key], true);
        } elseif (array_key_exists($key, $fileData2)) {
            return "+ $key: " . var_export($fileData2[$key], true);
        }
    }, $sortedKeys);
    echo "{\n" . implode("\n", $diff) . "\n}\n";
}
