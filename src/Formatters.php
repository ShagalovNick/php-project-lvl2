<?php

namespace Hexlet\Code\Formatters;

function chooseFormater(string $formatter)
{
    $fileName = ucfirst($formatter);
    return "Hexlet\\Code\\Formatters\\{$fileName}\\{$formatter}";
}
