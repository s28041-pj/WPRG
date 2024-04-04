<?php

$text = "Lorem Ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque vel lorem id ante tincidunt varius. Nulla id iaculis sapien, non congue nisl. Nulla placerat dolor ac rhoncus rhoncus. Vestibulum euismod enim ex, a malesuada metus vehicula sit amet. Curabitur nec mollis ligula. Quisque quam odio, feugiat non felis vel, tincidunt maximus ante. Quisque tincidunt velit nunc, ac finibus nibh porta nec. Cras maximus purus id lorem eleifend fermentum.";
$words = explode(" ", $text);

$words = removePunctualMarks($words);
$assocArray = fillAssocArray($words);
echoWords($assocArray);

function removePunctualMarks($words)
{
    for ($i = 0; $i < count($words); $i++) {
        $lastChar = substr($words[$i], -1);

        if ($lastChar == "." || $lastChar == ",") {

            for ($j = $i; $j < count($words) - 1; $j++) {
                $words[$j] = $words[$j + 1];
            }

            array_pop($words);
            $i--;
        }
    }
    return $words;
}

function fillAssocArray($words)
{
    $assocArray = [];

    for ($i = 0; $i < count($words); $i += 2) {
        $assocArray[$words[$i]] = isset($words[$i + 1]) ? $words[$i + 1] : "";
    }
    return $assocArray;
}

function echoWords($assocArray)
{
    echo "Key       Value \n";

    foreach ($assocArray as $key => $value) {
        echo $key . " => " . $value . "\n";
    }
}