<?php
$counterFile = 'counter.txt';

if (file_exists($counterFile)) {
    $counter = increaseVisitorCounter($counterFile);
} else {
    $counter = createNewFile($counterFile);
}
    echo "<p>Number of visitors: $counter</p>";

function increaseVisitorCounter($counterFile): int
{
    $handle = fopen($counterFile, 'r+');
    if (filesize($counterFile) > 0) {
        fseek($handle, 0);
        $counter = intval(fgets($handle)) + 1;
    } else {
        $counter = 1;
    }

    fseek($handle, 0);

    fwrite($handle, $counter);

    fclose($handle);

    return $counter;
}

function createNewFile($counterFile): int
{
    $handle = fopen($counterFile, 'w');
    $counter = 1;
    fwrite($handle, $counter);
    return $counter;
}
?>
