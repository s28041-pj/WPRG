<?php
require_once '../config/database.php';
require_once '../classes/User.php';
require_once '../classes/Log.php';

session_start();

$conn = db_connect();
$user = new User($conn);
$log = new Log($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->id = $_POST['id'];
    $user->role = $_POST['role'];
    if ($user->update_role()) {
        $user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : null;
        if ($user_id !== null) {
            $log->add_log($_SESSION['user_id'], "Edited role of user {$user->id}");
        }
        header("Location: /Projekt/admin/users.php");
    } else {
        echo "Error: Could not update user role.";
    }
} else {
    $user->id = $_GET['id'];
    $user_data = $user->read_by_id($user->id);
}

include '../views/admin_header.php';
?>

<h2>Edit User Role</h2>

<form action="edit_user.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $user->id; ?>">
    <label for="username">Username:</label>
    <input type="text" name="username" value="<?php echo $user_data['username']; ?>" disabled>
    <br>
    <label for="role">Role:</label>
    <select name="role">
        <option value="administrator" <?php if ($user_data['role'] == 'administrator') echo 'selected'; ?>>Admin</option>
        <option value="author" <?php if ($user_data['role'] == 'author') echo 'selected'; ?>>Author</option>
        <option value="user" <?php if ($user_data['role'] == 'user') echo 'selected'; ?>>User</option>
    </select>
    <br>
    <button type="submit">Update Role</button>
</form>

<?php include '../views/footer.php'; ?>
