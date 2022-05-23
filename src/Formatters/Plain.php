<?php

namespace Hexlet\Code\Formatters\Plain;

use function Functional\sort;

function getArrPlain(array $dif, $path = '')
{
    global $resultPlain;
    $result = array_map(function ($key, $value) use ($path){
        global $resultPlain;
        if (isset($value['old']) && isset($value['new'])) {
            if (is_array($value['new']) && is_array($value['old'])) {
                return [$path . "." . $key => ' was updated. From ' . '[complex value]' . ' to ' . '[complex value]'];
            } elseif (is_array($value['new'])) {
                return [$path . "." . $key => ' was updated. From ' . "'{$value['old']}'" . ' to ' . '[complex value]'];
            } elseif (is_array($value['old'])) {
                return [$path . "." . $key => ' was updated. From ' . '[complex value]' . ' to ' . "'{$value['new']}'"];
            } else {
                return [$path . "." . $key => ' was updated. From ' . "'{$value['old']}'" . ' to ' . "'{$value['new']}'"];
            }
            //is_array($value['new']) ? $value['new'] = '[complex value]' : $value['new'] = "'{$value['new']}'";
            //is_array($value['old']) ? $value['old'] = '[complex value]' : $value['old'] = "'{$value['old']}'";
            //return [$path . "." . $key => ' was updated. From ' . $value['old'] . ' to ' . $value['new']];
        } elseif (isset($value['new'])) {
            if (is_array($value['new'])) {
                return [$path . "." . $key => ' was added with value: ' . '[complex value]'];                
            } else {
                return [$path . "." . $key => ' was added with value: ' . "'{$value['new']}'"];                
            }
            //is_array($value['new']) ? $value['new'] = '[complex value]' : $value['new'] = "'{$value['new']}'";
            //return [$path . "." . $key => ' was added with value: ' . $value['new']];
        } elseif (isset($value['old'])) {
            return [$path . "." . $key => ' was removed'];
        } elseif (is_array($value) && !isset($value['nodif'])) {
            return getArrPlain($value, $path . '.' . $key);
            
        }
    }, array_keys($dif), array_values($dif));
    /*foreach ($dif as $key => $value) {
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
    }*/
    //ksort($resultPlain);
    return array_merge(...array_filter($result));
}

function plain(array $dif, array $resultArr = [])
{
    //$resultStr = '';
    //$result = [];
    $result = getArrPlain($dif);
    $fixFalse = str_replace("'false'", 'false', $result);
    $fixTrue = str_replace("'true'", 'true', $fixFalse);
    $fixNull = str_replace("'null'", 'null', $fixTrue);
    $fixResult = str_replace("'0'", '0', $fixNull);
    //print_r($result);
    /*foreach ($fixResult as $key => $value) {
        $fixPoint = substr($key, 1);
        $resultStr .= 'Property ' . "'{$fixPoint}'" . $value . PHP_EOL;
    }*/
    $resultArr = array_map(function ($key, $value){
        $fixPoint = substr($key, 1);
        return 'Property ' . "'{$fixPoint}'" . $value;
    }, array_keys($fixResult), array_values($fixResult));
    $resultSort = sort($resultArr, function ($left, $right) use ($resultArr) {
        return strcmp((string) $left, (string) $right);
    }, true);
    $resultStr = implode(PHP_EOL, $resultSort);
    //$fixNewLine = substr($dffd, 0, -1);
    echo $resultStr;
    return $resultStr;
}
