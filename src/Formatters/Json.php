<?php

namespace Differ\Formatters\Json;

function formatJson(array $diff): string
{
    return json_encode($diff, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
}
