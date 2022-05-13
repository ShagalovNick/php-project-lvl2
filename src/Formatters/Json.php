<?php

namespace Hexlet\Code\Formatters\Json;

use function Functional\sort;

function getArrJson(array $dif)
{
    ksort($dif); //7
    array_map(function ($key, $value) use (&$result) {
        if (!isset($value['old']) && !isset($value['new']) && !isset($value['nodif'])) {
            if (is_array($value)) {
                $result [$key] = getArrJson($value);
            }
        }
        $arFormat = ['old' => "- ", 'new' => "+ ", 'nodif' => ""];
        array_map(function ($arkey, $arvalue) use (&$result, $value, $key) {
            if (isset($value[$arkey])) {
                $result[$arvalue . $key] = $value[$arkey];
            }
        }, array_keys($arFormat), array_values($arFormat));
    }, array_keys($dif), array_values($dif));
    return $result;
}

function json(array $dif)
{
    $result = getArrJson($dif);
    if (file_put_contents("chart_data.json", json_encode($result, JSON_UNESCAPED_UNICODE))) {
        echo json_encode($result, JSON_PRETTY_PRINT);
        $resultStr = json_encode($result, JSON_PRETTY_PRINT);
        return $resultStr;
    } else {
        echo 'Error';
        return false;
    }
}
