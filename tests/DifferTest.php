<?php

namespace Hexlet\Code\DifferTest;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGendiff(): void
    {
        $expected = '{
  - follow: false
    host: hexlet.io
  - proxy: 123.234.53.22
  - timeout: 50
  + timeout: 20
  + verbose: true
}';
        $this->assertEquals($expected, genDiff('tests/fixtures/file1.json', 'tests/fixtures/file2.json'));

    }
}