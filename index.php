<?php

require_once __DIR__. '/vendor/autoload.php';

use function Differ\Differ\genDiff;

$result = genDiff('tests/fixtures/file1.json', 'tests/fixtures/file2.json');
print_r ($result);
