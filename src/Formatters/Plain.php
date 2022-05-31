<?php

namespace Hexlet\Code\Formatters\Plain;

use function Functional\sort;

function getArrPlain(array $dif, string $path = '')
{
    global $resultPlain;
    $result = array_map(function ($key, $value) use ($path) {
        global $resultPlain;
        if (isset($value['old']) && isset($value['new'])) {
            $text = ' was updated. From ';
            if (is_array($value['new']) && is_array($value['old'])) {
                return [$path . "." . $key => $text . '[complex value]' . ' to ' . '[complex value]'];
            } elseif (is_array($value['new'])) {
                return [$path . "." . $key => $text . "'{$value['old']}'" . ' to ' . '[complex value]'];
            } elseif (is_array($value['old'])) {
                return [$path . "." . $key => $text . '[complex value]' . ' to ' . "'{$value['new']}'"];
            } else {
                return [$path . "." . $key => $text . "'{$value['old']}'" . ' to ' . "'{$value['new']}'"];
            }
        } elseif (isset($value['new'])) {
            if (is_array($value['new'])) {
                return [$path . "." . $key => ' was added with value: ' . '[complex value]'];
            } else {
                return [$path . "." . $key => ' was added with value: ' . "'{$value['new']}'"];
            }
        } elseif (isset($value['old'])) {
            return [$path . "." . $key => ' was removed'];
        } elseif (is_array($value) && !isset($value['nodif'])) {
            return getArrPlain($value, $path . '.' . $key);
        }
    }, array_keys($dif), array_values($dif));
    return array_merge(...array_filter($result));
}

function plain(array $dif)
{
    $result = getArrPlain($dif);
    print_r($result);
    $fixFalse = str_replace("'false'", 'false', $result);
    $fixTrue = str_replace("'true'", 'true', $fixFalse);
    $fixNull = str_replace("'null'", 'null', $fixTrue);
    $fixResult = str_replace("'0'", '0', $fixNull);
    $resultArr = array_map(function ($key, $value) {
        $fixPoint = substr((string) $key, 1);
        return 'Property ' . "'{$fixPoint}'" . $value;
    }, array_keys((array) $fixResult), array_values((array) $fixResult));
    $resultSort = sort($resultArr, function ($left, $right) {
        return strcmp((string) $left, (string) $right);
    }, true);
    $resultStr = implode(PHP_EOL, $resultSort);
    echo $resultStr;
    return $resultStr;
}
