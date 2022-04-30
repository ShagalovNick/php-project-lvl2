<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;
use function Hexlet\Code\Differ\genDiff;

// класс UtilsTest наследует класс TestCase
// имя класса совпадает с именем файла
class DifferTest extends TestCase
{
    // Метод, функция определенная внутри класса
    // Должна начинаться со слова test
    // public – чтобы PHPUnit мог вызвать этот тест снаружи
    public function testGendiff(): void
    {
        // Сначала идет ожидаемое значение (expected)
        // И только потом актуальное (actual)

        $result = "{
  - follow: false
    host: hexlet.io
  - proxy: 123.234.53.22
  - timeout: 50
  + timeout: 20
  + verbose: true
}
";
        $this->assertEquals($result, genDiff('tests/fixtures/file1.json', 'tests/fixtures/file2.json'));
    }
}
