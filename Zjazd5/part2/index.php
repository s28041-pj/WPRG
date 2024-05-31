<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cars web</title>
    <style>
        nav {
            background-color: #f8f8f8;
            padding: 10px;
        }
        nav a {
            margin-right: 15px;
        }
        body {
            background-color: #f8f8f8;
        }
    </style>
</head>
<body>
<nav>
    <a href="allCars.php">All cars</a>
    <a href="addCar.php">Add car</a>
</nav>
<h1>Cars web</h1>
<hr>
<?php
if (isset($_GET['page'])) {
    include($_GET['page'] . '.php');
} else {
    include('cheapestCars.php');
}
?>
</body>
</html>
