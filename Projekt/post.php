<?php
require_once 'config/database.php';
require_once 'classes/Comment.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = db_connect();
    $comment = new Comment($conn);
    $comment->post_id = $_GET['id'];
    $comment->user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $comment->content = $_POST['content'];

    if ($comment->create()) {
        header('Location: post.php?id=' . $_GET['id']);
    } else {
        echo "Error adding comment.";
    }
}

include 'views/post.php';
?>
