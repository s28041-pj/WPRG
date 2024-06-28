<?php
require_once 'config/database.php';
require_once 'classes/Post.php';

$conn = db_connect();
$post = new Post($conn);
$posts = $post->read_all();

include 'header.php';
?>

<h2>Recent Posts</h2>
<?php while ($row = $posts->fetch_assoc()): ?>
    <article>
        <h3><a href="post.php?id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></h3>
        <p><?php echo substr($row['content'], 0, 150) . '...'; ?></p>
        <img src="<?php echo UPLOAD_DIR . $row['image']; ?>" alt="<?php echo $row['title']; ?>" width="200">
        <p>Posted on: <?php echo $row['created_at']; ?></p>
    </article>
<?php endwhile; ?>

<?php include 'footer.php'; ?>
