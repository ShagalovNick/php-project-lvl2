<?php

namespace Hexlet\Code\Parsers;

function getFile($file1, $file2)
{
    if (stripos($file1, '.json')) {
        $parse1 = 'json_decode';
        $parse2 = 'file_get_contents';
    } elseif (stripos($file1, '.yml')) {
        $parse1 = 'Symfony\Component\Yaml\Yaml::parseFile';
        $parse2 = 'lcfirst';
    }
    $arrFile1 = $parse1($parse2(realpath($file1)), true);
    $arrFile2 = $parse1($parse2(realpath($file2)), true);
    return [$arrFile1, $arrFile2];
}
