<?php
require_once 'config/database.php';
require_once 'classes/Post.php';
require_once 'classes/Comment.php';
require_once 'classes/User.php';

session_start();

$conn = db_connect();
$post = new Post($conn);
$comment = new Comment($conn);

$post->id = $_GET['id'];
$post_data = $post->read_single();
$comments = $comment->read_by_post($post->id);

$previous_post = $post->get_previous_post($post->id);
$next_post = $post->get_next_post($post->id);

include 'views/header.php';
?>

<article>
    <h2><?php echo $post_data['title']; ?></h2>
    <?php if (isset($_SESSION['role']) && ($_SESSION['role'] == 'administrator' || $_SESSION['role'] == 'author')): ?>
        <div class="edit">
            <a href="/admin/edit_post.php?id=<?php echo $post->id; ?>">Edit Post</a> |
            <a href="/admin/delete_post.php?id=<?php echo $post->id; ?>" onclick="return showConfirmationPopup(<?php echo $post->id; ?>);">Delete Post</a>

            <div id="confirmationPopup" class="confirmation-popup">
                <h3>Are you sure you want to delete this post?</h3>
                <button id="confirmDeleteButton">Yes</button>
                <button onclick="hideConfirmationPopup()">No</button>
            </div>
        </div>
    <?php endif; ?>
    <p class="postCon"><?php echo $post_data['content']; ?></p>
    <?php if (!empty($post_data['image'])): ?>
        <img src="<?php echo 'uploads/' . $post_data['image']; ?>" alt="<?php echo $post_data['title']; ?>" width="300">
    <?php endif; ?>
    <p class="confPopUp">Posted on: <?php echo $post_data['created_at']; ?></p>
    <script>
        function showConfirmationPopup(postId) {
            document.getElementById('confirmationPopup').style.display = 'block';
            document.getElementById('confirmDeleteButton').onclick = function() {
                window.location.href = 'delete_post.php?id=' + postId;
            };
            return false;
        }

        function hideConfirmationPopup() {
            document.getElementById('confirmationPopup').style.display = 'none';
        }
    </script>
    <style>
        .confirmation-popup, .error-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 999;
            text-align: center;
        }

        .confirmation-popup button {
            margin: 5px;
        }
    </style>

</article>

<section class="comments">
    <h3>Comments</h3>
    <?php while ($row = $comments->fetch_assoc()): ?>
        <div class="comment">
            <div class="avatar">
                <p><?php
                    if (!empty($row['user_id'])) {
                        $user = new User($conn);
                        $userData = $user->read_by_id($row['user_id']);
                        echo $userData['username'];
                    } else {
                        echo 'Guest';
                    }
                    ?>
                </p>
            </div>
            <div class="comment-user">
                <p class="content"><?php echo $row['content']; ?></p>
                <div class="created">
                    <p>Commented on: <?php echo $row['created_at']; ?></p>
                </div>
            </div>
        </div>

    <?php endwhile; ?>

    <h4>Add a Comment</h4>
    <form action="add_comment.php" method="POST">
        <textarea name="content" required></textarea>
        <input type="hidden" name="post_id" value="<?php echo $post->id; ?>">

        <button class="add-comment" type="submit">Add Comment</button>
    </form>

    <div style="margin-top: 20px;">
        <?php if ($next_post): ?>
            <a href="post.php?id=<?php echo $next_post['id']; ?>" class="button" style="margin-left: 10px;">Next Post</a>
        <?php endif; ?>
        <?php if ($previous_post): ?>
            <a href="post.php?id=<?php echo $previous_post['id']; ?>" class="button">Previous Post</a>
        <?php endif; ?>
    </div>
</section>

<?php include 'views/footer.php'; ?>
