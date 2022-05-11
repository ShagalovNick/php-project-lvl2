<?php

namespace Hexlet\Code\Formatters;

function chooseFormatter($formatter)
{
    $fileName = ucfirst($formatter);
    return "Hexlet\\Code\\Formatters\\{$fileName}\\{$formatter}";
}
