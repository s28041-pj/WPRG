<?php
require_once '../config/database.php';
require_once '../classes/Post.php';
require_once '../classes/Log.php';

session_start();

$conn = db_connect();
$post = new Post($conn);
$log = new Log($conn);

$post->id = $_GET['id'];

if ($post->delete()) {
    $user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : null;
    if ($user_id !== null) {
        $log->add_log($_SESSION['user_id'], "Deleted post ID {$post->id}");
    }
    if ($_SESSION['role'] == 'administrator') {
        header('Location: admin_dashboard.php');
    } elseif ($_SESSION['role'] == 'author') {
        header('Location: ../index.php');
    }
    exit();
} else {
    echo "Error deleting post.";
}
?>
