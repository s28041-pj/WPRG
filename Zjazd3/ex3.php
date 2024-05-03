<!DOCTYPE html>
<html>
<head>
    <title>Task handling form</title>
</head>
<body>
<h1>Task handling form</h1>

<form action="" method="POST">
    <label for="path">Path:</label>
    <input type="text" id="path" name="path" required><br><br>
    <label for="directory">Directory:</label>
    <input type="text" id="directory" name="directory" required><br><br>
    <label for="operation">Operation:</label>
    <select id="operation" name="operation">
        <option value="read" selected>Read</option>
        <option value="delete">Delete</option>
        <option value="create">Create</option>
    </select><br><br>
    <input type="submit" value="Submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $path = $_POST['path'];
    $directory = $_POST['directory'];
    $operation = $_POST['operation'];

    handle_directory_operation($path, $directory, $operation);
}

function handle_directory_operation($path, $directory, $operation = 'read') {
    if (substr($path, -1) !== "/") {
        $path .= "/";
    }

    if (!is_dir($path . $directory) && $operation !== 'create') {
        echo "Directory '$directory' not exists.";
        return;
    }

    switch ($operation) {
        case 'read':
            readFilesFromDirectory($path, $directory);
            break;
        case 'delete':
            deleteDirectory($path, $directory);
            break;
        case 'create':
            createDirectory($path, $directory);
            break;
        default:
            echo "Wrong operation '$operation'.";
            break;
    }
}

function readFilesFromDirectory($path, $directory)
{
    $files = scandir($path . $directory);
    echo "Files in directory '$directory':";
    echo "<ul>";
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo "<li>$file</li>";
        }
    }
    echo "</ul>";
}

function deleteDirectory($path, $directory)
{
    if (count(glob($path . $directory . "/*")) === 0) {
        if (rmdir($path . $directory)) {
            echo "Directory '$directory' is deleted.";
        } else {
            echo "Cannot delete directory '$directory'.";
        }
    } else {
        echo "Directory '$directory' is not empty and cannot be deleted.";
    }
}

function createDirectory($path, $directory)
{
    if (is_dir($path . $directory)) {
        echo "Directory '$directory' already exists.";
    } else {
        if (mkdir($path . $directory, 0777, true)) {
            echo "Directory '$directory' was created.";
        } else {
            echo "Cannot create directory '$directory'.";
        }
    }
}
?>
</body>
</html>