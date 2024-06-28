<?php
require_once '../config/database.php';
require_once '../classes/User.php';
require_once '../classes/Log.php';

session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'user' && $_SESSION['role'] != 'author')) {
    header('Location: /Projekt/index.php');
    exit;
}

$conn = db_connect();
$user = new User($conn);
$log = new Log($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    $user->id = $_SESSION['user_id'];
    $user->password = password_hash($new_password, PASSWORD_DEFAULT);

    if ($user->reset_password()) {
        $user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : null;
        if ($user_id !== null) {
            $log->add_log($_SESSION['user_id'], "Reset password {$user->id}");
        }
        echo "Password reset successful.";
    } else {
        echo "Password reset failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
<?php include '../views/header.php'; ?>

<h2>Reset Password</h2>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" id="new_password" required>
    <button type="submit">Reset Password</button>
</form>

<?php include '../views/footer.php'; ?>
</body>
</html>
