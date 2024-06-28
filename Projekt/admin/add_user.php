<?php
require_once '../config/database.php';
require_once '../classes/User.php';
require_once '../classes/Log.php';

session_start();

$conn = db_connect();
$log = new Log($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User($conn);
    $user->username = $_POST['username'];
    $user->email = $_POST['email'];
    $user->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $user->role = $_POST['role'];
    if ($user->create()) {
        $user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : null;
        if ($user_id !== null) {
            $log->add_log($_SESSION['user_id'], "Added a new user {$user->username}");
        }
        header("Location: /Projekt/admin/users.php");
    } else {
        echo "Error: Could not create user.";
    }
}

include '../views/admin_header.php';
?>

<h2>Add New User</h2>

<form action="add_user.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    <br>
    <label for="role">Role:</label>
    <select name="role">
        <option value="administrator">Admin</option>
        <option value="author">Author</option>
        <option value="user">User</option>
    </select>
    <br>
    <button type="submit">Add User</button>
</form>

<?php include '../views/footer.php'; ?>
