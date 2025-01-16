<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $filepath): array
{
    $extension = pathinfo($filepath, PATHINFO_EXTENSION);

    switch ($extension) {
        case 'json':
            $jsonContent = file_get_contents($filepath);
            $data = json_decode($jsonContent, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Failed to decode JSON from file: $filepath. Error: " . json_last_error_msg());
            }
            break;

        case 'yml':
        case 'yaml':
            $data = Yaml::parseFile($filepath);
            break;

        default:
            throw new \Exception("Unsupported file format: $extension");
    }

    return $data;
}
