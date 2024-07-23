<?php

require_once __DIR__. '/vendor/autoload.php';

use function Differ\Differ\genDiff;

genDiff('tests/fixtures/file3.yml', 'tests/fixtures/file2.json');
