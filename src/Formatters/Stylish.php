<?php

namespace Hexlet\Code\Formatters\Stylish;

function getArrStylish(array $dif, $level = 0)
{
    global $level;
    ksort($dif);
    foreach ($dif as $key => $value) {
        if (is_array($value)) {
            if (!isset($value['old']) && !isset($value['new']) && !isset($value['nodif'])) {
                echo addIndent($level++) . "  " . $key . ": {" . PHP_EOL;
                echo addIndent($level) . "  " . getArrStylish($value, $level) . PHP_EOL;
            }
            foreach (['old' => "- ", 'new' => "+ ", 'nodif' => "  "] as $arkey => $arvalue) {
                if (isset($value[$arkey])) {
                    if (is_array($value[$arkey])) {
                        echo addIndent($level++) . $arvalue . $key . ": {" . PHP_EOL;
                        echo addIndent($level) . "  " . getArrStylish($value[$arkey], $level) . PHP_EOL;
                    } else {
                        echo addIndent($level) . $arvalue . $key . ": " . $value[$arkey] . PHP_EOL;
                    }
                }
            }
        } else {
            echo addIndent($level) . "  " . $key . ': ' . $value . PHP_EOL;
        }
    }
    $level = $level - 1;
    return "}";
}

function addIndent($level)
{
    return str_repeat(" ", $level * 4 + 2);
}

function stylish(array $dif)
{
    echo "{" . PHP_EOL;
    getArrStylish($dif);
    echo "}" . PHP_EOL;
}