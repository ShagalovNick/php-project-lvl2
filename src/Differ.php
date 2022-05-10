<?php

namespace Hexlet\Code\Differ;

use Symfony\Component\Yaml\Yaml;
use Hexlet\Code\Formatter;

use function Hexlet\Code\Parsers\getFile;


function boolToString($value)
{
    return (!is_bool($value) ? $value : ($value ? 'true' : 'false'));
}

function genDiff($file1, $file2, $formatter = "Hexlet\Code\Formatter\stylish")
{
    [$arrFile1, $arrFile2] = getFile($file1, $file2);
    $result = array_merge_recursive($arrFile1, $arrFile2);
    $dif = getDif($result, $arrFile1, $arrFile2);
    echo "{" . PHP_EOL;
    $formatter($dif);
    echo "}" . PHP_EOL;
    return $dif;
}

function keyToDiff($arr1, $arr2, string $key, $value)
{
    $result = [];
    if (isset($value[1]) && (array_key_exists($key, $arr1))) {
        if ($value[1] === $arr1[$key]) {
            $result['nodif'] = $key . ': ' . boolToString($value[1]);
            return $result;
        }
    }
        $arrrr = ['old' => $arr1, 'new' => $arr2];
    foreach ($arrrr as $ark => $arval) {
        if (array_key_exists($key, $arval)) {
            if (is_array($arval[$key])) {
                $result[$ark] = $arval[$key];
            } else {
                $result[$ark] = is_null($arval[$key]) ? $key . ': ' . "null" : $key . ': ' . boolToString($arval[$key]);
            }
        }
    }
    return $result;
}

function getDif($result, $arr1, $arr2, $key = '', $value = [])
{
    foreach ($result as $key => $value) {
        if (!isset($arr1[$key]) || !isset($arr2[$key]) || !is_array($arr1[$key]) || !is_array($arr2[$key])) {
            $dif[$key] = keyToDiff($arr1, $arr2, $key, $value);
        } else {
            $dif[$key] = getDif($value, $arr1[$key], $arr2[$key], $key, $value);
        }
    }
        return $dif;
}


