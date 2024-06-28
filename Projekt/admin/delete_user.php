<?php
require_once '../config/database.php';
require_once '../classes/User.php';
require_once '../classes/Log.php';

session_start();

$conn = db_connect();
$user = new User($conn);
$log = new Log($conn);

if (isset($_GET['id'])) {
    $user->id = $_GET['id'];
    if ($user->delete()) {
        $user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : null;
        if ($user_id !== null) {
            $log->add_log($_SESSION['user_id'], "Deleted user {$user->id}");
        }
        header("Location: /Projekt/admin/users.php");
    } else {
        echo "Error: Could not delete user.";
    }
}
?>
