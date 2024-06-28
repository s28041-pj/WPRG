<?php
require_once 'config/database.php';
require_once 'classes/User.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = db_connect();
    $user = new User($conn);
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    if ($user->authenticate()) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['role'] = $user->role;
        setcookie('user_id', $user->id, time() + (15 * 60), "/");
        header('Location: index.php');
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}

include 'views/header.php';
?>

<div class="container mt-5 d-flex justify-content-center">
    <div class="card" style="max-width: 400px; width: 100%;">
        <div class="card-body">
            <h2 class="mb-4 text-center">Login</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" required />
                    <label class="form-label" for="email">Email</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" required />
                    <label class="form-label" for="password">Password</label>
                </div>

                <button type="submit" class="btn btn-secondary btn-block mb-4">Sign in</button>

                <div class="text-center">
                    <p>Not a member? <a href="register.php" class="register-link">Register</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'views/footer.php'; ?>
