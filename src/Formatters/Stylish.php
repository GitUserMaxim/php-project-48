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

function formatStylish(mixed $value, string $replacer = ' ', int $spaceCount = 4): string
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
        $indImmut = str_repeat($replacer, $indentLength);
        $indMut = str_repeat($replacer, $indentLength - $shiftToLeft);
        $bracketIndent = str_repeat($replacer, $indentLength - $spaceCount);

        $strings = array_map(
            function ($item, $key) use ($indImmut, $indMut, $iter, $depth) {
                return formatItem($item, $key, $indMut, $indImmut, $iter, $depth);
            },
            $currentValue,
            array_keys($currentValue)
        );

        $result = ['{', ...$strings, $bracketIndent . '}'];
        return implode("\n", $result);
    };

    return $iter($value, 1);
}

function formatItem(mixed $item, string $key, string $indMut, string $indImmut, callable $iter, int $depth): string
{
    if (!is_array($item)) {
        return "{$indImmut}{$key}: {$iter($item, $depth + 1)}";
    }
    if (!array_key_exists('type', $item)) {
        return "{$indImmut}{$key}: {$iter($item, $depth + 1)}";
    }

    switch ($item['type']) {
        case 'added':
            return "{$indMut}+ {$item['key']}: {$iter($item['value'] ?? 'null', $depth + 1)}";
        case 'deleted':
            return "{$indMut}- {$item['key']}: {$iter($item['value'] ?? 'null', $depth + 1)}";
        case 'changed':
                $oldValue = $iter($item['value1'] ?? 'null', $depth + 1);
                $newValue = $iter($item['value2'] ?? 'null', $depth + 1);
            return "{$indMut}- {$item['key']}: {$oldValue}\n{$indMut}+ {$item['key']}: {$newValue}";
        case 'unchanged':
            return "{$indImmut}{$item['key']}: {$iter($item['value'] ?? 'null', $depth + 1)}";
        case 'nested':
            return "{$indImmut}{$item['key']}: {$iter($item['children'] ?? [], $depth + 1)}";
        default:
            return "{$indImmut}{$key}: {$iter($item, $depth + 1)}";
    }
}
