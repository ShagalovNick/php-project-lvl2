<?php

namespace Differ\Differ;

use function Hexlet\Code\Parsers\getFile;
use function Hexlet\Code\Formatters\chooseFormater;
use function Functional\sort;

function genDiff(string $file1, string $file2, string $formatter = 'stylish')
{
    [$arrFile1, $arrFile2] = getFile($file1, $file2);
    $resultArr = array_merge_recursive($arrFile1, $arrFile2);
    $dif = getDif($resultArr, $arrFile1, $arrFile2);
    $format = chooseFormater($formatter);
    $result = $format($dif);
    return $result;
}

function keyToDiff(array $arr1, array $arr2, string $key)
{
    $arrDif = ['old' => $arr1, 'new' => $arr2];
    $result = array_map(function ($arKey, $arValue) use ($key) {
        if (array_key_exists($key, $arValue)) {
            if (is_array($arValue[$key])) {
                return [$arKey => $arValue[$key]];
            } else {
                $val = !is_bool($arValue[$key]) ? $arValue[$key] : ($arValue[$key] ? 'true' : 'false');
                return [$arKey => is_null($arValue[$key]) ? "null" : $val];
            }
        }
    }, array_keys($arrDif), array_values($arrDif));
    return array_merge(...array_filter($result));
}

function getDif(array $result, array $arr1, array $arr2, string $key = '')
{
    $dif = array_map(function ($key, $value) use ($arr1, $arr2) {
        if (!isset($arr1[$key]) || !isset($arr2[$key]) || !is_array($arr1[$key]) || !is_array($arr2[$key])) {
            if (isset($value[1]) && (array_key_exists($key, $arr1)) && ($value[1] === $arr1[$key])) {
                return [$key => ['nodif' => !is_bool($value[1]) ? $value[1] : ($value[1] ? 'true' : 'false')]];
            } else {
                return [$key => keyToDiff($arr1, $arr2, $key)];
            }
        } else {
            return [$key => getDif($value, $arr1[$key], $arr2[$key], $key)];
        }
    }, array_keys($result), array_values($result));
        return array_merge(...array_filter($dif));
}
