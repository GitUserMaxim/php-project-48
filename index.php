<?php

require_once __DIR__. '/vendor/autoload.php';

use function Differ\Differ\genDiff;

genDiff('src/file1.json', 'src/file2.json');
