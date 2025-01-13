<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $filepath): array
{
    $extension = pathinfo($filepath, PATHINFO_EXTENSION);

    if ($extension === 'json') {
        $data = json_decode(file_get_contents($filepath), true);
        if ($data === false) {
            throw new \Exception("Failed to read file: $filepath");
        }
    } elseif (in_array($extension, ['yml', 'yaml'], true)) {
        $data = Yaml::parseFile($filepath);
    } else {
        throw new \Exception("Unsupported file format: $extension");
    }

    return $data;
}
