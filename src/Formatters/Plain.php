<?php

namespace Hexlet\Code\Formatters\Plain;

function getArrPlain(array $dif, $path = '')
{
    global $resultPlain;
    foreach ($dif as $key => $value) {
        if (isset($value['old']) && isset($value['new'])) {
            is_array($value['new']) ? $value['new'] = '[complex value]' : $value['new'] = "'{$value['new']}'";
            is_array($value['old']) ? $value['old'] = '[complex value]' : $value['old'] = "'{$value['old']}'";
            $resultPlain[$path . "." . $key] = ' was updated. From ' . $value['old'] . ' to ' . $value['new'];
        } elseif (isset($value['new'])) {
            is_array($value['new']) ? $value['new'] = '[complex value]' : $value['new'] = "'{$value['new']}'";
            $resultPlain[$path . "." . $key] = ' was added with value: ' . $value['new'];
        } elseif (isset($value['old'])) {
            $resultPlain[$path . "." . $key] = ' was removed';
        } elseif (is_array($value) && !isset($value['nodif'])) {
            $x = getArrPlain($value, $path . '.' . $key);
            $resultPlain = $x;
        }
    }
    ksort($resultPlain);
    $resultPlain = str_replace("'false'", 'false', $resultPlain);
    $resultPlain = str_replace("'true'", 'true', $resultPlain);
    $resultPlain = str_replace("'null'", 'null', $resultPlain);
    return $resultPlain;
}

function plain($dif)
{
    $result = [];
    $result = getArrPlain($dif);
    print_r($result);
    foreach ($result as $key => $value) {
        $key = substr($key, 1);
        echo 'Property ' . "'{$key}'" . $value . PHP_EOL;
    }
}
