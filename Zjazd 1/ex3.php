<?php

$keySpace = "  ";
$valueSpaceBefore10 = "        ";
$valueSpaceAfter10 = "       ";
$N = 13;
$fibonacci = [0, 1];

echo "Index     Value \n";

$fibonacci = fibonacciSequence($N, $fibonacci);
showFibonacci($fibonacci, $keySpace, $valueSpaceBefore10, $valueSpaceAfter10);

function fibonacciSequence($N, $fibonacci)
{
    for ($i = 2; $i < $N; $i++) {
        $fibonacci[$i] = $fibonacci[$i - 1] + $fibonacci[$i - 2];
    }
    return $fibonacci;
}
function showFibonacci($fibonacci, $keySpace, $valueSpaceBefore10, $valueSpaceAfter10)
{
    foreach ($fibonacci as $key => $value) {
        if ($value % 2 !== 0) {
            if ($key <= 9)
                echo $keySpace . ($key + 1) . "." . $valueSpaceBefore10 . $value . "\n";
            else echo $keySpace . ($key + 1) . "." . $valueSpaceAfter10 . $value . "\n";
        }
    }
}