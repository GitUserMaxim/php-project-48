<?php

namespace Differ\Formatters\Plain;

function toString(mixed $value): string
{
    if (is_array($value)) {
        return '[complex value]';
    }
    if ($value === null) {
        return 'null';
    }
    return var_export($value, true);
}

function plainFormat(array $diff, string $parentKey = ''): string
{
    return implode(PHP_EOL, array_filter(array_map(function ($node) use ($parentKey) {
        $key = $node['key'];
        $fullKey = $parentKey === '' ? $key : "{$parentKey}.{$key}";

        return match ($node['type']) {
            'added' => sprintf(
                "Property '%s' was added with value: %s",
                $fullKey,
                toString($node['value'])
            ),
            'deleted' => sprintf("Property '%s' was removed", $fullKey),
            'unchanged' => null,
            'changed' => sprintf(
                "Property '%s' was updated. From %s to %s",
                $fullKey,
                toString($node['valueOld']),
                toString($node['valueNew'])
            ),
            'nested' => plainFormat($node['children'], $fullKey),
            default => null,
        };
    }, $diff)));
}
