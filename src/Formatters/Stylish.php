<?php

namespace Hexlet\Code\Formatters\Stylish;

use function Functional\sort;

function getArrStylish(array $dif, int $level = 0, string $path = '')
{
    $difSort = sort($dif, function ($left, $right) use ($dif) {
        return strcmp((string) array_search($left, $dif, true), (string) array_search($right, $dif, true));
    }, true);
    $result = array_map(function ($key, $value) use ($level) {
        if (is_array($value)) {
            if (!isset($value['old']) && !isset($value['new']) && !isset($value['nodif'])) {
                    return getArrStylish($value, $level + 1, addIndent($level) . "  " . $key . ": {" . PHP_EOL);
            } else {
                $arFormat = ['old' => "- ", 'new' => "+ ", 'nodif' => "  "];
                $resultDif = array_map(function ($arkey, $arvalue) use ($value, $key, $level) {
                    if (isset($value[$arkey])) {
                        if (is_array($value[$arkey])) {
                            $keyDifArray = addIndent($level) . $arvalue . $key . ": {" . PHP_EOL;
                            return getArrStylish($value[$arkey], $level + 1, $keyDifArray);
                        } else {
                                    return addIndent($level) . $arvalue . $key . ": " . $value[$arkey] . PHP_EOL;
                        }
                    }
                }, array_keys($arFormat), array_values($arFormat));
                return implode(array_filter($resultDif));
            }
        } else {
            return addIndent($level) . "  " . $key . ': ' . $value . PHP_EOL;
        }
    }, array_keys($difSort), array_values($difSort));
    return implode('', [$path, ...$result]) . addIndent($level - 0.5) . "}" . PHP_EOL;
}

function addIndent(int $level)
{
    return str_repeat(" ", $level * 4 + 2);
}

function stylish(array $dif)
{
    $result = "{" . PHP_EOL . getArrStylish($dif);
    echo substr($result, 0, -1);
    return substr($result, 0, -1);
}
