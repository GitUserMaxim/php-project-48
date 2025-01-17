<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $fileData, string $extension): array
{
    $data = match ($extension) {
        'json' => json_decode($fileData, true, JSON_THROW_ON_ERROR),
        'yml', 'yaml' => Yaml::parse($fileData),
        default => throw new \Exception("Unsupported file format: $extension"),
    };

    return $data;
}
