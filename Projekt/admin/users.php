<?php
require_once '../config/database.php';
require_once '../classes/User.php';

session_start();

$conn = db_connect();
$user = new User($conn);
$users = $user->read_all();

include '../views/admin_header.php';
?>

<h2>Manage Users</h2>

<a href="/Projekt/admin/add_user.php">Add New User</a>

<table>
    <tr>
        <th>Username</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $users->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['role']; ?></td>
            <td>
                <a href="/Projekt/admin/edit_user.php?id=<?php echo $row['id']; ?>">Edit Role</a>
                <a href="/Projekt/admin/delete_user.php?id=<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<?php include '../views/footer.php';?>
