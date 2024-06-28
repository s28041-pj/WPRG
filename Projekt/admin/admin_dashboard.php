<?php
require_once '../config/database.php';
require_once '../classes/Post.php';

session_start();

$conn = db_connect();
$post = new Post($conn);
$posts = $post->read_all();

include '../views/admin_header.php';
?>

<div class="admin-dash">
    <h2>Admin Dashboard</h2>
    <nav>
        <ul>
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['role'] === 'administrator'): ?>
                    <li><a href="users.php">Manage Users</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['role'] === 'administrator'): ?>
                    <li><a href="admin_logs.php">Logs</a></li>
                <?php endif; ?>
                <li><a href="/Projekt/admin/admin_add_post.php">Add Post</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>


<div class="table">
    <table>
        <tr>
            <th>Title</th>
            <th>Content</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $posts->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo substr($row['content'], 0, 50) . '...'; ?></td>
                <td>
                    <?php if (!empty($row['image'])): ?>
                        <img src="<?php echo '../uploads/' . $row['image']; ?>" alt="<?php echo $row['title']; ?>" width="100">
                    <?php else: ?>
                        No image
                    <?php endif; ?>
                </td>
                <td>
                    <a href="/Projekt/admin/edit_post.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a href="/Projekt/admin/delete_post.php?id=<?php echo $row['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include '../views/footer.php';?>
