<?php
include 'config.php';

global $pdo;

$stmt = $pdo->query("SELECT * FROM cars ORDER BY year DESC");
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

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
<body>
<nav>
    <a href="index.php">Main page</a>
    <a href="allCars.php">All cars</a>
    <a href="addCar.php">Add car</a>
</nav>
<h2>All cars</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Brand</th>
        <th>Model</th>
        <th>Price</th>
        <th>Details</th>
    </tr>
    <?php foreach ($cars as $car): ?>
        <tr>
            <td><?php echo htmlspecialchars($car['id']); ?></td>
            <td><?php echo htmlspecialchars($car['brand']); ?></td>
            <td><?php echo htmlspecialchars($car['model']); ?></td>
            <td><?php echo htmlspecialchars($car['price']); ?></td>
            <td><a href="details.php?id=<?php echo $car['id']; ?>">Details</a></td>
        </tr>
    <?php endforeach; ?>
</table>