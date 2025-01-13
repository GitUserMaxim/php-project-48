<?php

namespace Differ\Formatters\Stylish;

function toString(mixed $value): string
{
    if (is_null($value)) {
        return 'null';
    } elseif (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    return trim(var_export($value, true), "'");
}

function stylishFormat(mixed $value, string $replacer = ' ', int $spaceCount = 4): string
{
    if (!is_array($value)) {
        return toString($value);
    }

    $iter = function ($currentValue, $depth) use (&$iter, $replacer, $spaceCount) {
        if (!is_array($currentValue)) {
            return toString($currentValue);
        }

        $indentLength = $spaceCount * $depth;
        $shiftToLeft = 2;
        $indentImmutableType = str_repeat($replacer, $indentLength);
        $indentMutableType = str_repeat($replacer, $indentLength - $shiftToLeft);
        $bracketIndent = str_repeat($replacer, $indentLength - $spaceCount);

        $strings = array_map(
            function ($item, $key) use ($indentImmutableType, $indentMutableType, $iter, $depth) {
                return formatItem($item, $key, $indentImmutableType, $indentMutableType, $iter, $depth);
            },
            $currentValue,
            array_keys($currentValue)
        );

        $result = ['{', ...$strings, $bracketIndent . '}'];
        return implode("\n", $result);
    };

    return $iter($value, 1);
}

function formatItem(mixed $item, string $key, string $indentImmutableType, string $indentMutableType, callable $iter, int $depth): string
{
    if (!is_array($item)) {
        return "{$indentImmutableType}{$key}: {$iter($item, $depth + 1)}";
    }
    if (!array_key_exists('type', $item)) {
        return "{$indentImmutableType}{$key}: {$iter($item, $depth + 1)}";
    }

    switch ($item['type']) {
        case 'added':
            return "{$indentMutableType}+ {$item['key']}: {$iter($item['value'] ?? 'null', $depth + 1)}";
        case 'deleted':
            return "{$indentMutableType}- {$item['key']}: {$iter($item['value'] ?? 'null', $depth + 1)}";
        case 'changed':
            return "{$indentMutableType}- {$item['key']}: {$iter($item['valueOld'] ?? 'null', $depth + 1)}\n" .
                   "{$indentMutableType}+ {$item['key']}: {$iter($item['valueNew'] ?? 'null', $depth + 1)}";
        case 'unchanged':
            return "{$indentImmutableType}{$item['key']}: {$iter($item['value'] ?? 'null', $depth + 1)}";
        case 'nested':
            return "{$indentImmutableType}{$item['key']}: {$iter($item['children'] ?? [], $depth + 1)}";
        default:
            return "{$indentImmutableType}{$key}: {$iter($item, $depth + 1)}";
    }
}
