<?php

namespace Hexlet\Code\Formatter;

function stylish(array $dif, $level = 0)
{
    global $level;
    ksort($dif);
    foreach ($dif as $key => $value) {
        if (is_array($value)) {
            if (!isset($value['old']) && !isset($value['new']) && !isset($value['nodif'])) {
                echo str_repeat(" ", $level * 4 + 2) . "  " . $key . ": {" . PHP_EOL;
                $level = $level + 1;
                $resultDif = stylish($value, $level);
                echo str_repeat(" ", $level * 4 + 2) . "  " . $resultDif . PHP_EOL;
            }
            $arFormat = ['old' => "- ", 'new' => "+ ", 'nodif' => "  "];
            foreach ($arFormat as $arkey => $arvalue) {
                if (isset($value[$arkey])) {
                    if (is_array($value[$arkey])) {
                        echo str_repeat(" ", $level * 4 + 2) . $arvalue . $key . ": {" . PHP_EOL;
                        $level = $level + 1;
                        $resultDif = stylish($value[$arkey], $level);
                        echo str_repeat(" ", $level * 4 + 2) . "  " . $resultDif . PHP_EOL;
                    } else {
                        echo str_repeat(" ", $level * 4 + 2) . $arvalue . $value[$arkey] . PHP_EOL;
                    }
                }
            }
        } else {
            echo str_repeat(" ", $level * 4 + 2) . "  " . $key . ': ' . $value . PHP_EOL;
        }
    }
    $level = $level - 1;
    return "}";
}