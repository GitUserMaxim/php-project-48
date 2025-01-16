<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $filepath): array
{
    $extension = pathinfo($filepath, PATHINFO_EXTENSION);

    switch ($extension) {
        case 'json':
            $jsonContent = file_get_contents($filepath);
            if ($jsonContent === false) {
                throw new \Exception("Can't read a file: $filepath");
            }

            $data = json_decode($jsonContent, true, JSON_THROW_ON_ERROR);
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
