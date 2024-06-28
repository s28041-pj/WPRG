<?php
require_once '../config/database.php';
require_once '../classes/Log.php';

session_start();

if ($_SESSION['role'] !== 'administrator') {
    header('Location: index.php');
    exit;
}

$conn = db_connect();
$log = new Log($conn);
$logs = $log->read_all();

include '../views/admin_header.php';
?>

<h2>User Activity Logs</h2>
<table>
    <tr>
        <th>Username</th>
        <th>Action</th>
        <th>Timestamp</th>
    </tr>
    <?php while ($row = $logs->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['action']; ?></td>
            <td><?php echo $row['timestamp']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<?php include '../views/footer.php'; ?>
