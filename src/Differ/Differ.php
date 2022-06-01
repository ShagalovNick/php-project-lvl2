<?php

namespace Differ\Differ;

/*$autoloadPath1 = __DIR__ . '/../../../autoload.php';
$autoloadPath2 = __DIR__ . '/../../vendor/autoload.php';
if (file_exists($autoloadPath1)) {
    require_once $autoloadPath1;
} else {
    require_once $autoloadPath2;
}*/

//use Symfony\Component\Yaml\Yaml;
//use Hexlet\Code\Formatters;
//use Hexlet\Code\Formatters\Stylish;
//use Hexlet\Code\Formatters\Plain;

use function Hexlet\Code\Parsers\getFile;
use function Hexlet\Code\Formatters\chooseFormater;
use function Functional\sort;

/*function boolToString($value)
{
    return (!is_bool($value) ? $value : ($value ? 'true' : 'false'));
}*/

function genDiff(string $file1, string $file2, string $formatter = 'stylish')
{
    [$arrFile1, $arrFile2] = getFile($file1, $file2);
    $resultArr = array_merge_recursive($arrFile1, $arrFile2);
    $dif = getDif($resultArr, $arrFile1, $arrFile2);
    //ksort($dif);
    //print_r($dif);
    //$dif = sort($dif, fn ($left, $right) => strnatcmp($left, $right), true);
    //print_r($dif);
    $format = chooseFormater($formatter);
    $result = $format($dif);
    return $result;
}

function keyToDiff(array $arr1, array $arr2, string $key)
{
    //$result = [];
    /*if (isset($value[1]) && (array_key_exists($key, $arr1)) && ($value[1] === $arr1[$key])) {
            //$result['nodif'] = boolToString($value[1]);
            //return $result;
            return ['nodif' => !is_bool($value[1]) ? $value[1] : ($value[1] ? 'true' : 'false')];
    }*/
    // start foreach
    /*foreach (['old' => $arr1, 'new' => $arr2] as $ark => $arval) {
        if (array_key_exists($key, $arval)) {
            if (is_array($arval[$key])) {
                $result[$ark] = $arval[$key];
            } else {
                $result[$ark] = is_null($arval[$key]) ? "null" : boolToString($arval[$key]);
            }
        }
    }*/
    // end foreach
    //else {
    $arrDif = ['old' => $arr1, 'new' => $arr2];
    $result = array_map(function ($arKey, $arValue) use ($key) {
        if (array_key_exists($key, $arValue)) {
            if (is_array($arValue[$key])) {
                return [$arKey => $arValue[$key]];
                //$result[$arKey] = $arValue[$key];
            } else {
                $val = !is_bool($arValue[$key]) ? $arValue[$key] : ($arValue[$key] ? 'true' : 'false');
                return [$arKey => is_null($arValue[$key]) ? "null" : $val];
                //$result[$arKey] = is_null($arValue[$key]) ? "null" : boolToString($arValue[$key]);
            }
        }
    }, array_keys($arrDif), array_values($arrDif));
    //return $result;
    return array_merge(...array_filter($result));
//}
}

function getDif(array $result, array $arr1, array $arr2, string $key = '')
{
    $dif = array_map(function ($key, $value) use ($arr1, $arr2) {
        if (!isset($arr1[$key]) || !isset($arr2[$key]) || !is_array($arr1[$key]) || !is_array($arr2[$key])) {
            //$dif[$key] = keyToDiff($arr1, $arr2, $key, $value);
            if (isset($value[1]) && (array_key_exists($key, $arr1)) && ($value[1] === $arr1[$key])) {
                //$result['nodif'] = boolToString($value[1]);
                //return $result;
                return [$key => ['nodif' => !is_bool($value[1]) ? $value[1] : ($value[1] ? 'true' : 'false')]];
            } else {
                return [$key => keyToDiff($arr1, $arr2, $key)];
            }
        } else {
            //$dif[$key] = getDif($value, $arr1[$key], $arr2[$key], $key);
            return [$key => getDif($value, $arr1[$key], $arr2[$key], $key)];
        }
    }, array_keys($result), array_values($result));
    //start foreach
    /*foreach ($result as $key => $value) {
        if (!isset($arr1[$key]) || !isset($arr2[$key]) || !is_array($arr1[$key]) || !is_array($arr2[$key])) {
            $dif[$key] = keyToDiff($arr1, $arr2, $key, $value);
        } else {
            $dif[$key] = getDif($value, $arr1[$key], $arr2[$key], $key);
        }
    }*/
    // end foreach
        //return $dif;
        return array_merge(...array_filter($dif));
}
