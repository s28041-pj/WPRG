<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['cart_number'] = $_POST['cart_number'];
    $_SESSION['op_details'] = $_POST['op_details'];
    $_SESSION['people_number'] = $_POST['people_number'];
    header('Location: peopleData.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>General form</title>
</head>
<style>
    body {
        background-color: #f8f8f8;
    }
</style>
<body>
<form method="post" action="">
    <label for="cart_number">Cart number:</label>
    <input type="text" id="cart_number" name="cart_number" required><br>

    <label for="op_details">Ordering party details:</label>
    <input type="text" id="op_details" name="op_details" required><br>

    <label for="people_number">People number:</label>
    <input type="number" id="people_number" name="people_number" min="1" required><br>

    <input type="submit" value="Next">
</form>
</body>
</html>
