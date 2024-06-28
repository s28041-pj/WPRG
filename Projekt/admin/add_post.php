<?php
require_once '../config/database.php';
require_once '../classes/Post.php';
require_once '../classes/Log.php';

session_start();

$conn = db_connect();
$post = new Post($conn);
$log = new Log($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post->title = $_POST['title'];
    $post->content = $_POST['content'];
    $post->image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $post->image);

    if ($post->create()) {
        $user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : null;
        if ($user_id !== null) {
            $log->add_log($_SESSION['user_id'], "Added a new post {$post->title}");
        }
        header('Location: admin_dashboard.php');
    } else {
        echo "Error adding post.";
    }
}

include '../views/header.php';
?>

<h2>Add Post</h2>
<form action="add_post.php" method="POST" enctype="multipart/form-data">
    <label for="title">Title:</label>
    <input type="text" name="title" required>
    <label for="content">Content:</label>
    <textarea name="content" required></textarea>
    <label for="image">Image:</label>
    <input type="file" name="image">
    <button type="submit">Add Post</button>
</form>

<?php include '../views/footer.php'; ?>
