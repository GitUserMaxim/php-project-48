<?php

namespace Hexlet\Code\DifferTest;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGendiffJsonJsonStilish(): void
    {
        $expected = file_get_contents('tests/fixtures/expectedStylish.txt');

        $this->assertEquals($expected, genDiff('tests/fixtures/file1.json', 'tests/fixtures/file2.json', 'stylish'));
    }


    public function testGendiffJsonJsonPlain(): void
    {
        $expectedPlain = file_get_contents('tests/fixtures/expectedPlain.txt');

        $this->assertEquals($expectedPlain, genDiff('tests/fixtures/file1.json', 'tests/fixtures/file2.json', 'plain'));
    }


    public function testGendiffYamlYmlPlain(): void
    {
        $expected = file_get_contents('tests/fixtures/expectedPlain.txt');

        $this->assertEquals($expected, genDiff('tests/fixtures/file3.yml', 'tests/fixtures/file4.yaml', 'plain'));
    }


    public function testGendiffYamlYmlStylish(): void
    {
        $expected = file_get_contents('tests/fixtures/expectedStylish.txt');

        $this->assertEquals($expected, genDiff('tests/fixtures/file3.yml', 'tests/fixtures/file4.yaml', 'stylish'));
    }

    public function testGendiffYamlJsonStylish(): void
    {
        $expected = file_get_contents('tests/fixtures/expectedStylish.txt');

        $this->assertEquals($expected, genDiff('tests/fixtures/file1.json', 'tests/fixtures/file4.yaml', 'stylish'));
    }

    public function testGendiffJsonYamlJson(): void
    {
        $expected = file_get_contents('tests/fixtures/expectedJson.txt');

        $this->assertEquals($expected, genDiff('tests/fixtures/file1.json', 'tests/fixtures/file4.yaml', 'json'));
    }

    public function testGendiffJson2Json(): void
    {
        $expected = file_get_contents('tests/fixtures/expectedJson.txt');

        $this->assertEquals($expected, genDiff('tests/fixtures/file1.json', 'tests/fixtures/file2.json', 'json'));
    }
}
