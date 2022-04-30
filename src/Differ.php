<?php

namespace Hexlet\Code\Differ;

function valueToString($value)
{
    return (!is_bool($value) ? $value : ($value ? 'true' : 'false'));
}

function genDiff($file1, $file2)
{
    $file1Str = file_get_contents(realpath($file1));
    $file2Str = file_get_contents(realpath($file2));
    $arrFile1 = json_decode($file1Str, true);
    $arrFile2 = json_decode($file2Str, true);
    $result = array_merge(array_diff_assoc($arrFile2, $arrFile1), $arrFile1);
    ksort($result);

    $dif = [];
    //$dif = "{";
    foreach ($result as $key => $value) {
        if (!array_key_exists($key, $arrFile1)) {
            $dif[] = '  + ' . $key . ': ' . valueToString($value);
        } elseif (!array_key_exists($key, $arrFile2)) {
            $dif[] = '  - ' . $key . ': ' . valueToString($value);
        } elseif ($value === $arrFile2[$key]) {
            $dif[] = '    ' . $key . ': ' . valueToString($value);
        } else {
            $dif[] = '  - ' . $key . ': ' . $value;
            $dif[] = '  + ' . $key . ': ' . valueToString($arrFile2[$key]);
        }
    }
    $dif[] = '}' . PHP_EOL;

    $resultDif = '{';
    foreach ($dif as $value) {
        $resultDif .= PHP_EOL . $value;
    }
    echo $resultDif;
    return $resultDif;
}
