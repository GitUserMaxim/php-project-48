<?php

namespace Differ\Formatters\Json;

function jsonFormat(array $diff): string
{
    return json_encode($diff, JSON_PRETTY_PRINT);
}
