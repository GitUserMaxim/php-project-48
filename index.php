<?php

require_once __DIR__. '/vendor/autoload.php';

use function Differ\Differ\genDiff;

$result = genDiff('tests/fixtures/file3.yml', 'tests/fixtures/file4.yaml');
print_r ($result);
