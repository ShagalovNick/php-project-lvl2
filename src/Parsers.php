<?php

namespace Hexlet\Code\Parsers;

function getFile(string $file1, string $file2)
{
    if (stripos($file1, '.json') > 0) {
        $parse1 = 'json_decode';
        $parse2 = 'file_get_contents';
    } elseif (stripos($file1, '.yml') > 0 || stripos($file1, '.yaml') > 0) {
        $parse1 = 'Symfony\Component\Yaml\Yaml::parseFile';
        $parse2 = 'lcfirst';
    } else {
        return false;
    }
    $arrFile1 = $parse1($parse2((string) realpath($file1)), true);
    $arrFile2 = $parse1($parse2((string) realpath($file2)), true);
    return [$arrFile1, $arrFile2];
}
