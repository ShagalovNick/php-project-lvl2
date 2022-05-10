<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;
use function Hexlet\Code\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGendiff(): void
    {
        $dif = genDiff('tests/fixtures/filepath1.json', 'tests/fixtures/filepath2.json');
        $this->assertEquals(['new' => 'follow: false'], $dif['common']['follow']);
        $this->assertEquals(['nodif' => 'foo: bar'], $dif['group1']['foo']);
        $this->assertEquals(['old' => ['key' => 'value'], 'new' => 'nest: str'], $dif['group1']['nest']);
    }
}
