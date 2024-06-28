<?php
function db_connect() {
    $host = 'localhost';
    $db_name = 'blog';
    $username = 'root';
    $password = '';

    $conn = new mysqli($host, $username, $password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    createTables($conn);
    addSampleUsers($conn);

    return $conn;
}

function createTables($conn) {
    $users_table = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('administrator', 'author', 'user') NOT NULL,
        UNIQUE (username),
        UNIQUE (email)
    )";

    $posts_table = "CREATE TABLE IF NOT EXISTS posts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        image VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $comments_table = "CREATE TABLE IF NOT EXISTS comments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        post_id INT NOT NULL,
        user_id INT,
        content TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (post_id) REFERENCES posts(id),
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";

    $logs_table = "CREATE TABLE IF NOT EXISTS logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        action VARCHAR(255) NOT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";

    $tables = [$users_table, $posts_table, $comments_table, $logs_table];

    foreach ($tables as $table) {
        if ($conn->query($table) === TRUE) {
        } else {
            die("Error creating table: " . $conn->error);
        }
    }
}

function addSampleUsers($conn) {
    $sample_users = [
        ['username' => 'author', 'email' => 'author@author.author', 'password' => password_hash('author', PASSWORD_BCRYPT), 'role' => 'author'],
        ['username' => 'admin', 'email' => 'admin@admin.admin', 'password' => password_hash('admin', PASSWORD_BCRYPT), 'role' => 'administrator'],
        ['username' => 'user', 'email' => 'user@user.user', 'password' => password_hash('user', PASSWORD_BCRYPT), 'role' => 'user']
    ];

    foreach ($sample_users as $user) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param('ss', $user['username'], $user['email']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $user['username'], $user['email'], $user['password'], $user['role']);
            $stmt->execute();
        }

        $stmt->close();
    }
}

?>
