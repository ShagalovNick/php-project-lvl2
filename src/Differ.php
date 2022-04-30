<?php

namespace Hexlet\Code\Differ;

function valueToString($value)
{
    return (!is_bool($value) ? $value : ($value ? 'true' : 'false'));
}

function getFile($file1, $file2)
{
    $arrFile1 = json_decode(file_get_contents(realpath($file1)), true);
    $arrFile2 = json_decode(file_get_contents(realpath($file2)), true);
    return [$arrFile1, $arrFile2];
}

function genDiff($file1, $file2)
{
    [$arrFile1, $arrFile2] = getFile($file1, $file2);
    $result = array_merge(array_diff_assoc($arrFile2, $arrFile1), $arrFile1);
    ksort($result);

    $dif = [];
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
