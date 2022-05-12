<?php

namespace Hexlet\Code\Formatters\Json;

function getArrJson(array $dif, $result = [])
{
    ksort($dif);
    foreach ($dif as $key => $value) {
        if (!isset($value['old']) && !isset($value['new']) && !isset($value['nodif'])) {
            if (is_array($value)) {
                $result [$key] = getArrJson($value);
            }
        }
        $arFormat = ['old' => "- ", 'new' => "+ ", 'nodif' => ""];
        foreach ($arFormat as $arkey => $arvalue) {
            if (isset($value[$arkey])) {
                $result[$arvalue . $key] = $value[$arkey];
            }
        }
    }
    return $result;
}

function json($dif)
{
    $result = getArrJson($dif);
    file_put_contents("chart_data.json", json_encode($result, JSON_UNESCAPED_UNICODE));
    echo json_encode($result, JSON_PRETTY_PRINT);
    $resultStr = json_encode($result, JSON_PRETTY_PRINT);
    return $resultStr;
}
