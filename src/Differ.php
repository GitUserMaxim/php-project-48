<?php

namespace Differ\Differ;

use function Functional\sort;
use function Differ\Parsers\parseFile;
use function Differ\Formatter\formatOutput;

function genDiff(string $filePath1, string $filePath2, string $formatName = 'stylish')
{
    $fileData1 = parseFile($filePath1); // читаем файл, декодируем в массив
    $fileData2 = parseFile($filePath2);

    $diff = buildDiffTree($fileData1, $fileData2);
    $result = formatOutput($diff, $formatName);
    return $result;
}



function buildDiffTree(array $fileData1, array $fileData2)
{
    $keys = array_unique(array_merge(array_keys($fileData1), array_keys($fileData2))); //находим все ключи

    $sortedKeys = sort($keys, fn ($left, $right) => strcmp($left, $right)); // сортируем ключи по алфавиту

    $diffTree = array_map(function ($key) use ($fileData1, $fileData2) {

        $value1 = $fileData1[$key] ?? null;
        $value2 = $fileData2[$key] ?? null;

        if (!array_key_exists($key, $fileData2)) {
            return ['key' => $key, 'type' => 'deleted', 'value' => $value1];
        }
        if (!array_key_exists($key, $fileData1)) {
            return ['key' => $key, 'type' => 'added', 'value' => $value2];
        }

        if ($value1 === $value2) {
            return ['key' => $key, 'type' => 'unchanged', 'value' => $value1];
        }

        if ((is_array($value1) && !array_is_list($value1)) && (is_array($value2) && !array_is_list($value2))) {
            return ['key' => $key, 'type' => 'nested',
                'children' => buildDiffTree($value1, $value2)];
        }

        return ['key' => $key, 'type' => 'changed', 'valueOld' => $value1, 'valueNew' => $value2];
    }, $sortedKeys);

    return $diffTree;
}
