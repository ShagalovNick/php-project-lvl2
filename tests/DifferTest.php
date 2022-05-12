<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;
use function Hexlet\Code\Formatters\Plain\getArrPlain;
use function Hexlet\Code\Formatters\Json\getArrJson;
use function Hexlet\Code\Parsers\getFile;
use function Differ\Differ\getDif;

class DifferTest extends TestCase
{
    public function testGendiff(): void
    {
        $dif = genDiff('tests/fixtures/filepath1.json', 'tests/fixtures/filepath2.json', 'stylish');
        $this->assertEquals(92, strpos($dif, '- setting3'));
    }

    public function testGetArrPlain(): void
    {
        [$arrFile1, $arrFile2] = getFile('tests/fixtures/filepath1.json', 'tests/fixtures/filepath2.json');
        $result = array_merge_recursive($arrFile1, $arrFile2);
        $dif = getDif($result, $arrFile1, $arrFile2);
        $res = getArrPlain($dif);
        $this->assertEquals(' was updated. From true to null', $res['.common.setting3']);
    }

    public function testGetArrJson(): void
    {
        [$arrFile1, $arrFile2] = getFile('tests/fixtures/filepath1.yaml', 'tests/fixtures/filepath2.yaml');
        $result = array_merge_recursive($arrFile1, $arrFile2);
        $dif = getDif($result, $arrFile1, $arrFile2);
        $res = getArrJson($dif);
        $this->assertEquals('true', $res['common']['- setting3']);
        $this->assertEquals('bar', $res['group1']['foo']);
        $this->assertEquals('100500', $res['+ group3']['fee']);
    }
}
