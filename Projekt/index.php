<?php
require_once 'config/database.php';
require_once 'classes/Post.php';

session_start();

$conn = db_connect();
$post = new Post($conn);
$posts = $post->read_all();

if (isset($_SESSION['role']) && $_SESSION['role'] === 'administrator') {
    include 'views/admin_header.php';
} else {
    include 'views/header.php';
}
?>

<?php if (isset($_SESSION['user_id'])): ?>
    <?php if ($_SESSION['role'] === 'administrator' || $_SESSION['role'] === 'author'): ?>
        <a href="add_post.php" class="button">Add Post</a>
    <?php endif; ?>
<?php endif; ?>

<h2>Recent Posts</h2>
<?php while ($row = $posts->fetch_assoc()): ?>
    <article>
        <h3 class="post"><a href="post.php?id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></h3>
        <p class="postCon"><?php echo substr($row['content'], 0, 200); ?>...</p>
        <?php if (!empty($row['image'])): ?>
            <img src="<?php echo 'uploads/' . $row['image']; ?>" alt="<?php echo $row['title']; ?>">
        <?php endif; ?>
        <p class="confPopUp">Posted on: <?php echo $row['created_at']; ?></p>
    </article>
<?php endwhile; ?>

<?php include 'views/footer.php'; ?>
