<?php

namespace Hexlet\Code\Formatters;

function chooseFormat($formatter)
{
    $fileName = ucfirst($formatter);
    return "Hexlet\\Code\\Formatters\\{$fileName}\\{$formatter}";
}
