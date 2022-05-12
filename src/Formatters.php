<?php

namespace Hexlet\Code\Formatters;

function chooseFormater($formatter)
{
    $fileName = ucfirst($formatter);
    return "Hexlet\\Code\\Formatters\\{$fileName}\\{$formatter}";
}
