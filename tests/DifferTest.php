<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;
use function Hexlet\Code\Differ\genDiff;
use function Hexlet\Code\Formatters\Plain\getArrPlain;

class DifferTest extends TestCase
{
    public function testGendiff(): void
    {
        $dif = genDiff('tests/fixtures/filepath1.json', 'tests/fixtures/filepath2.json', 'stylish');
        $this->assertEquals(['new' => 'false'], $dif['common']['follow']);
        $this->assertEquals(['nodif' => 'bar'], $dif['group1']['foo']);
        $this->assertEquals(['old' => ['key' => 'value'], 'new' => 'str'], $dif['group1']['nest']);
    }
    
    public function testGetArrPlain(): void
    {
        $dif = genDiff('tests/fixtures/filepath1.json', 'tests/fixtures/filepath2.json', 'plain');
        $result = getArrPlain($dif);
        $this->assertEquals(' was updated. From true to null', $result['.common.setting3']);
    }

}
