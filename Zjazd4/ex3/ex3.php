<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Link list</title>
</head>
<body>
<h1>Link list</h1>
<ul>
    <?php
    $file = 'links.txt';

    if (file_exists($file)) {
        $handle = fopen($file, 'r');

        if ($handle) {
            writeOutLinks($handle);
        } else {
            echo "<li style='color: red'>Error, cannot open the file $file</li>";
        }
    } else {
        echo "<li style='color: red'>File with links does not exist</li>";
    }

    function writeOutLinks($handle)
    {
        while (($line = fgets($handle)) !== false) {
            $parts = explode(' ', $line, 2);

            if (count($parts) === 2) {
                $url = trim($parts[0]);
                $description = trim($parts[1]);

                echo "<li><a href=\"$url\">$description</a></li>";
            } else {
                echo "<li style='color: red'>Error bad data format: $line</li>";
            }
        }
        fclose($handle);
    }
    ?>
</ul>
</body>
</html>
