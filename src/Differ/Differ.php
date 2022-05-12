<?php

namespace Differ\Differ;

use Symfony\Component\Yaml\Yaml;
use Hexlet\Code\Formatters;
use Hexlet\Code\Formatters\Stylish;
use Hexlet\Code\Formatters\Plain;

use function Hexlet\Code\Parsers\getFile;
use function Hexlet\Code\Formatters\chooseFormatter;

function boolToString($value)
{
    return (!is_bool($value) ? $value : ($value ? 'true' : 'false'));
}

function genDiff(string $file1, string $file2, string $formatter = 'stylish')
{
    [$arrFile1, $arrFile2] = getFile($file1, $file2);
    $result = array_merge_recursive($arrFile1, $arrFile2);
    $dif = getDif($result, $arrFile1, $arrFile2);
    ksort($dif);
    $formatter = chooseFormatter($formatter);
    $result = $formatter($dif);
    return $result;
}

function keyToDiff($arr1, $arr2, string $key, $value)
{
    $result = [];
    if (isset($value[1]) && (array_key_exists($key, $arr1)) && ($value[1] === $arr1[$key])) {
            $result['nodif'] = boolToString($value[1]);
            return $result;
    }
    foreach (['old' => $arr1, 'new' => $arr2] as $ark => $arval) {
        if (array_key_exists($key, $arval)) {
            if (is_array($arval[$key])) {
                $result[$ark] = $arval[$key];
            } else {
                $result[$ark] = is_null($arval[$key]) ? "null" : boolToString($arval[$key]);
            }
        }
    }
    return $result;
}

function getDif($result, $arr1, $arr2, $key = '')
{
    foreach ($result as $key => $value) {
        if (!isset($arr1[$key]) || !isset($arr2[$key]) || !is_array($arr1[$key]) || !is_array($arr2[$key])) {
            $dif[$key] = keyToDiff($arr1, $arr2, $key, $value);
        } else {
            $dif[$key] = getDif($value, $arr1[$key], $arr2[$key], $key);
        }
    }
        return $dif;
}
