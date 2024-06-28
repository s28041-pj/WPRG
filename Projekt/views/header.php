<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Blog</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/Projekt/styles.css">
</head>
<body>
<header>
    <h1><a href="/Projekt/index.php">IT Blog</a></h1>
    <nav>
        <ul>
            <li><a href="/Projekt/index.php">Home</a></li>
            <li><a href="/Projekt/contact.php">Contact</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['role'] === 'administrator'): ?>
                    <li><a href="/Projekt/admin_dashboard.php">Admin Dashboard</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['role'] == 'user' || $_SESSION['role'] == 'author'): ?>
                    <li><a href="/Projekt/reset_password.php">Reset Password</a></li>
                <?php endif; ?>
                <li><a href="/Projekt/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="/Projekt/login.php">Login</a></li>
                <li><a href="/Projekt/register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<main>
