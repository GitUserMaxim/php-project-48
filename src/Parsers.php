<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseFile($filepath)
{
    $extension = pathinfo($filepath, PATHINFO_EXTENSION);

    if ($extension === 'json') {
        $data = json_decode(file_get_contents($filepath), true);
    } elseif (in_array($extension, ['yml', 'yaml'], true)) {
        $data = Yaml::parseFile($filepath, Yaml::PARSE_OBJECT_FOR_MAP);
    } else {
        throw new \Exception("Unsupported file format: $extension");
    }

    return $data;
}