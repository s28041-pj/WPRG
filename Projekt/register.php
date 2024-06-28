<?php
require_once 'config/database.php';
require_once 'classes/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = db_connect();
    $user = new User($conn);
    $user->username = $_POST['username'];
    $user->email = $_POST['email'];
    $user->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $user->role = 'user';

    if ($user->create()) {
        header('Location: login.php');
    } else {
        echo "Error registering user.";
    }
}

include 'views/header.php';
?>

<div class="container mt-5 d-flex justify-content-center">
    <div class="card" style="max-width: 400px; width: 100%;">
        <div class="card-body">
            <h2 class="mb-4 text-center">Register</h2>
            <form action="register.php" method="POST">
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="username" name="username" class="form-control" required />
                    <label class="form-label" for="username">Username</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" required />
                    <label class="form-label" for="email">Email</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" required />
                    <label class="form-label" for="password">Password</label>
                </div>

                <button type="submit" class="btn btn-secondary btn-block mb-4">Register</button>

                <div class="text-center">
                    <p>Have an account? <a href="login.php" class="register-link">Sign in</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'views/footer.php'; ?>
