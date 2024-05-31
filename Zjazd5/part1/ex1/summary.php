<?php
session_start();
if (!isset($_SESSION['people_details'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Summary</title>
    <style>
        body {
            background-color: #f8f8f8;
        }
    </style>
</head>
<body>
<h2>Summary</h2>
<p>Cart number: <?php echo htmlspecialchars($_SESSION['cart_number']); ?></p>
<p>Order partying details: <?php echo htmlspecialchars($_SESSION['op_details']); ?></p>
<p>People number: <?php echo htmlspecialchars($_SESSION['people_number']); ?></p>

<?php
foreach ($_SESSION['people_details'] as $index => $person) {
    echo '<h3>Person ' . ($index + 1) . '</h3>';
    echo '<p>Name: ' . htmlspecialchars($person['name']) . '</p>';
    echo '<p>Surname: ' . htmlspecialchars($person['surname']) . '</p>';
}
?>

<a href="index.php">Back to first form</a>
</body>
</html>
