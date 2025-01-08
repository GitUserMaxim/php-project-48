<?php

namespace Differ\Formatter;

function toString(mixed $value): string
{
    if (is_null($value)) {
        return 'null';
    } elseif (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    return trim(var_export($value, true), "'");
}

function transformTree(mixed $value, string $replacer = ' ', int $spaceCount = 4): string
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
        $indentForImmutableType = str_repeat($replacer, $indentLength);
        $indentForMutableType = str_repeat($replacer, $indentLength - $shiftToLeft);
        $bracketIndent = str_repeat($replacer, $indentLength - $spaceCount);

        $strings = array_map(
            function ($item, $key) use ($indentForImmutableType, $indentForMutableType, $iter, $depth) {
                return formatItem($item, $key, $indentForImmutableType, $indentForMutableType, $iter, $depth);
            },
            $currentValue,
            array_keys($currentValue)
        );

        $result = ['{', ...$strings, $bracketIndent . '}'];
        return implode("\n", $result);
    };

    return $iter($value, 1);
}

function formatItem($item, $key, $indentForImmutableType, $indentForMutableType, $iter, $depth)
{
    if (!is_array($item)) {
        return $indentForImmutableType . $key . ': ' . $iter($item, $depth + 1);
    }
    if (!array_key_exists('type', $item)) {
        return $indentForImmutableType . $key . ': ' . $iter($item, $depth + 1);
    }

    switch ($item['type']) {
        case 'added':
            return $indentForMutableType . '+ ' . $item['key'] . ': ' . $iter($item['value'] ?? 'null', $depth + 1);
        case 'deleted':
            return $indentForMutableType . '- ' . $item['key'] . ': ' . $iter($item['value'] ?? 'null', $depth + 1);
        case 'changed':
            return $indentForMutableType . '- ' . $item['key'] . ': ' . $iter($item['valueOld'] ?? 'null', $depth + 1) .
                "\n" . $indentForMutableType . '+ ' . $item['key'] . ': ' . $iter($item['valueNew'] ?? 'null', $depth + 1);
        case 'unchanged':
            return $indentForImmutableType . $item['key'] . ': ' . $iter($item['value'] ?? 'null', $depth + 1);
        case 'nested':
            return $indentForImmutableType . $item['key'] . ': ' . $iter($item['children'] ?? [], $depth + 1);
        default:
            return $indentForImmutableType . $key . ': ' . $iter($item, $depth + 1);
    }
}
