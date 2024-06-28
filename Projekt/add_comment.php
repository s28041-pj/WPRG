<?php
require_once 'config/database.php';
require_once 'classes/Comment.php';
require_once 'classes/Log.php';

session_start();

$conn = db_connect();
$comment = new Comment($conn);
$log = new Log($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = db_connect();
    $comment = new Comment($conn);
    $comment->post_id = $_POST['post_id'];
    $comment->user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : null;
    $comment->content = $_POST['content'];

    if ($comment->create()) {
        if ($comment->user_id !== null) {
            $log->add_log($comment->user_id, "Added a comment on post ID {$comment->post_id}");
        }        header('Location: post.php?id=' . $_POST['post_id']);
    } else {
        echo "Error adding comment.";
    }
}
?>
