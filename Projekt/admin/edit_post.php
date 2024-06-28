<?php
require_once '../config/database.php';
require_once '../classes/Post.php';
require_once '../classes/Log.php';

session_start();

$conn = db_connect();
$post = new Post($conn);
$log = new Log($conn);

$post->id = $_GET['id'];
$post_data = $post->read_single();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post->title = $_POST['title'];
    $post->content = $_POST['content'];

    if (!empty($_FILES['image']['name'])) {
        $post->image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $post->image);
    } else {
        $post->image = $post_data['image'];
    }

    if ($post->update()) {
        $user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : null;
        if ($user_id !== null) {
            $log->add_log($_SESSION['user_id'], "Edited post ID {$post->id}");
        }
        if ($_SESSION['role'] == 'administrator') {
            header('Location: admin_dashboard.php');
        } elseif ($_SESSION['role'] == 'author') {
            header('Location: ../index.php');
        }
        exit();
    } else {
        echo "Error updating post.";
    }
}

include '../views/header.php';
?>

<div class="edit-post">
    <h2>Edit Post</h2>
    <form action="edit_post.php?id=<?php echo $post->id; ?>" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo $post_data['title']; ?>" required>
        <label for="content">Content:</label>
        <textarea name="content" required><?php echo $post_data['content']; ?></textarea>
        <label for="image">Image:</label>
        <input type="file" name="image">
        <button type="submit">Update Post</button>
    </form>
</div>

<?php include '../views/footer.php'; ?>
