<?php

$rangeStart = 1;
$rangeEnd = 50;

echo "Prime numbers: \n";

for ($i = $rangeStart; $i <= $rangeEnd; $i++) {
    if ($i === 1) {
        continue;
    }

    $isPrime = isPrime($i);

    showNumber($isPrime, $i);

}

function isPrime($i)
{
    $isPrime = true;
    for ($j = 2; $j < $i; $j++) {
        if ($i % $j === 0) {
            $isPrime = false;
            break;
        }
    }
    return $isPrime;
}

function showNumber($isPrime, $i)
{
    if ($isPrime) {
        echo $i . "\n";
    }
}