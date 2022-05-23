<?php

namespace Hexlet\Code\Formatters\Json;

use function Functional\sort;

function getArrJson(array $dif)
{
    //ksort($dif); //7
    $difSort = sort($dif, function ($left, $right) use ($dif) {
        return strcmp((string) array_search($left, $dif, false), (string) array_search($right, $dif, false));
    }, true);
    $result = array_map(function ($key, $value) {
        if (!isset($value['old']) && !isset($value['new']) && !isset($value['nodif'])) {
            if (is_array($value)) {
                return [$key => getArrJson($value)];
            }
        } else {
            $arFormat = ['old' => "- ", 'new' => "+ ", 'nodif' => ""];
            $resss = array_map(function ($arkey, $arvalue) use ($value, $key) {
                if (isset($value[$arkey])) {
                    return [$arvalue . $key => $value[$arkey]];
                }
            }, array_keys($arFormat), array_values($arFormat));
            return array_merge(...array_filter($resss));
        }
    }, array_keys($difSort), array_values($difSort));
    $result1 = array_merge(...$result);
    return $result1;
}

/*function getArrJson(array $dif)
{
    ksort($dif); //7
    array_map(function ($key, $value) use (&$result) {
        if (!isset($value['old']) && !isset($value['new']) && !isset($value['nodif'])) {
            if (is_array($value)) {
                $result[$key] = getArrJson($value);
            }
        } else {
            $arFormat = ['old' => "- ", 'new' => "+ ", 'nodif' => ""];
            array_map(function ($arkey, $arvalue) use (&$result, $value, $key) {
                if (isset($value[$arkey])) {
                    $result[$arvalue . $key] = $value[$arkey];
                }
                return 'yehooo';
            }, array_keys($arFormat), array_values($arFormat));
        }
        return 'yehooo';
    }, array_keys($dif), array_values($dif));
    return $result;
}*/

function json(array $dif)
{
    $resultDif = getArrJson($dif);
    //print_r($resultDif);
        $bytes = file_put_contents("chart_data.json", json_encode($resultDif, JSON_UNESCAPED_UNICODE));
        //echo $bytes . ' bytes at chart_data.json' . PHP_EOL;
        echo json_encode($resultDif, JSON_PRETTY_PRINT);
        $resultStr = json_encode($resultDif, JSON_PRETTY_PRINT);
        return $resultStr;
}
