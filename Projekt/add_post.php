<?php
require_once 'config/database.php';
require_once 'classes/Post.php';
require_once 'classes/Log.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = db_connect();
    $post = new Post($conn);
    $log = new Log($conn);
    $post->title = $_POST['title'];
    $post->content = $_POST['content'];

    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $post->image = $_FILES["image"]["name"];
        }
    }

    if ($post->create()) {
        $user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : null;
        if ($user_id !== null) {
            $log->add_log($user_id, "Added a new post {$post->title}");
        }        header('Location: index.php');
    } else {
        $error = "Error adding post.";
    }
}

include 'views/header.php';
?>

<h2>Add New Post</h2>
<?php if (isset($error)): ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>
<form action="add_post.php" method="POST" enctype="multipart/form-data">
    <label for="title">Title:</label>
    <input type="text" name="title" required>
    <label for="content">Content:</label>
    <textarea name="content" required></textarea>
    <label for="image">Image:</label>
    <input type="file" name="image">
    <button type="submit">Add Post</button>
</form>

<?php include 'views/footer.php'; ?>
