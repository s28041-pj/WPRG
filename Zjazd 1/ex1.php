<?php

$fruits = ["apple", "banana", "orange", "pineapple", "watermelon"];

foreach ($fruits as $fruit) {

    showReverserFruit($fruit);
    award($fruit);

    echo "\n";
}

function showReverserFruit($fruit)
{
    $reversedFruit = "";

    for ($i = strlen($fruit) - 1; $i >= 0; $i--) {
        $reversedFruit .= $fruit[$i];
    }

    echo $reversedFruit;
}

function award($fruit)
{
    if ($fruit[0] === "p") {
        echo " !starts from p! ";
    }
}