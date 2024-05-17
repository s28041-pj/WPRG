<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reverse rows in text file</title>
</head>
<body>
    <h1>Reverse rows in text file</h1>
    <form action="ex1.php" method="post" enctype="multipart/form-data">
        <label for="file">Enter the text file</label>
        <input type="file" id="file" name="file" accept=".txt">
        <button type="submit">Send</button>
    </form>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $partlyFileName = explode(".", $fileName);
    $fileExtension = strtolower(end($partlyFileName));

    if ($fileExtension == 'txt') {
        $newFileName = 'reversed_' . $fileName;

        $originalFile = fopen($fileTmpPath, 'r');
        $reversedFile = fopen($newFileName, 'w');

        if ($originalFile && $reversedFile) {
            proceedFile($originalFile, $reversedFile, $newFileName);
        } else {
            echo "<h2 style='color: red'>Error, cannot open files</h2>";
        }
    } else {
        echo "<h2 style='color: red'>Error, put file with txt extension</h2>";
    }
}

function proceedFile($originalFile, $reversedFile, $newFileName)
{
    $reversedContent = array();

    while (($line = fgets($originalFile)) !== false) {
        $reversedContent[] = $line;
    }

    $reversedContent = array_reverse($reversedContent);

    foreach ($reversedContent as $line) {
        fwrite($reversedFile, $line);
    }

    fclose($originalFile);
    fclose($reversedFile);

    echo "<h2 style='color: green'>File proceed correctly!</h2>";
    echo "<p><a href='$newFileName' download>Download reversed file</a></p>";
}
?>

