<?php
session_start();
if (!isset($_SESSION['people_number'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $people_details = [];
    for ($i = 0; $i < $_SESSION['people_number']; $i++) {
        $people_details[] = [
            'name' => $_POST["name_$i"],
            'surname' => $_POST["surname_$i"]
        ];
    }
    $_SESSION['people_details'] = $people_details;
    header('Location: summary.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form people data</title>
</head>
<style>
    body {
        background-color: #f8f8f8;
    }
</style>
<body>
<form method="post" action="">
    <?php
    for ($i = 0; $i < $_SESSION['people_number']; $i++) {
        echo '<h3>Person ' . ($i + 1) . '</h3>';
        echo '<label for="name_' . $i . '">Name:</label>';
        echo '<input type="text" id="name_' . $i . '" name="name_' . $i . '" required><br>';
        echo '<label for="surname_' . $i . '">Surname:</label>';
        echo '<input type="text" id="surname_' . $i . '" name="surname_' . $i . '" required><br>';
    }
    ?>
    <input type="submit" value="Save and next step">
</form>
</body>
</html>
