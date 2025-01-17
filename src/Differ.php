<?php

namespace Differ\Differ;

use function Functional\sort;
use function Differ\Parsers\parseFile;
use function Differ\Formatter\formatOutput;

function genDiff(string $filePath1, string $filePath2, string $formatName = 'stylish'): string
{
    return formatOutput(
        buildDiffTree(
            parseFile(getData($filePath1), getExtension($filePath1)),
            parseFile(getData($filePath2), getExtension($filePath2))
        ),
        $formatName
    );
}


function getExtension(string $filePath): string
{
    return $extension = pathinfo($filePath, PATHINFO_EXTENSION);
}

function getData(string $filePath): string
{
    $fileData = @file_get_contents($filePath);
    if ($fileData !== false) {
        return $fileData;
    }
    throw new \Exception("File not found");
}


function buildDiffTree(array $fileData1, array $fileData2): array
{
    $keys = array_unique(array_merge(array_keys($fileData1), array_keys($fileData2)));

    $sortedKeys = sort($keys, fn ($left, $right) => strcmp($left, $right));

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

        return ['key' => $key, 'type' => 'changed', 'value1' => $value1, 'value2' => $value2];
    }, $sortedKeys);

    return $diffTree;
}
