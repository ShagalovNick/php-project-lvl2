<?php

namespace Hexlet\Code\Differ;

function valueToString( $value ){ 
    return ( !is_bool( $value ) ?  $value : ($value ? 'true' : 'false' )  ); 
}

function genDiff($file1, $file2)
{
    $arrFile1 = json_decode(file_get_contents($file1), true);
    $arrFile2 = json_decode(file_get_contents($file2), true);
    $result = array_merge(array_diff_assoc($arrFile2, $arrFile1), $arrFile1);
    ksort($result);

    echo "{".PHP_EOL;
    foreach($result as $key => $value) {
        if (!array_key_exists($key, $arrFile1)) {
            echo '  + '.$key.': '.valueToString($value).PHP_EOL;
        } elseif (!array_key_exists($key, $arrFile2)) {
            echo '  - '.$key.': '.valueToString($value).PHP_EOL;
        } elseif ($value === $arrFile2[$key]) {
            echo '    '.$key.': '.valueToString($value).PHP_EOL;
        } else {
            echo '  - '.$key.': '.$value.PHP_EOL;
            echo '  + '.$key.': '.valueToString($arrFile2[$key]).PHP_EOL;
        }
    }
    echo "}".PHP_EOL;
}

