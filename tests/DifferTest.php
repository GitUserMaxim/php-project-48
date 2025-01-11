<?php

namespace Hexlet\Code\DifferTest;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGendiff(): void
    {
        $expected = file_get_contents('tests/fixtures/expectedStylish.txt');

        $this->assertEquals($expected, genDiff('tests/fixtures/file1.json', 'tests/fixtures/file2.json', 'stylish'));
    }


    public function testGendiffPlainFormatJson(): void
    {
        $expectedPlain = file_get_contents('tests/fixtures/expectedPlain.txt');

        $this->assertEquals($expectedPlain, genDiff('tests/fixtures/file1.json', 'tests/fixtures/file2.json', 'plain'));
    }


    public function testGendiffYamlPlain(): void
    {
        $expected = file_get_contents('tests/fixtures/expectedPlain.txt');

        $this->assertEquals($expected, genDiff('tests/fixtures/file3.yml', 'tests/fixtures/file4.yaml', 'plain'));
    }


    public function testGendiffYaml(): void
    {
        $expected = file_get_contents('tests/fixtures/expectedStylish.txt');

        $this->assertEquals($expected, genDiff('tests/fixtures/file3.yml', 'tests/fixtures/file4.yaml', 'stylish'));
    }

    public function testGendiffYamlJson(): void
    {
        $expected = file_get_contents('tests/fixtures/expectedStylish.txt');

        $this->assertEquals($expected, genDiff('tests/fixtures/file1.json', 'tests/fixtures/file4.yaml', 'stylish'));
    }
}
