<?php

class Post {
    private $conn;
    private $table = 'posts';

    public $id;
    public $title;
    public $content;
    public $image;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function get_previous_post($current_post_id) {
        $query = "SELECT * FROM $this->table WHERE id < ? ORDER BY id DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $current_post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function get_next_post($current_post_id) {
        $query = "SELECT * FROM $this->table WHERE id > ? ORDER BY id ASC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $current_post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create() {
        $query = "INSERT INTO $this->table (title, content, image, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sss', $this->title, $this->content, $this->image);
        return $stmt->execute();
    }

    public function read_all() {
        $query = "SELECT * FROM $this->table ORDER BY created_at DESC";
        return $this->conn->query($query);
    }

    public function read_single() {
        $query = "SELECT * FROM $this->table WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update() {
        $query = "UPDATE $this->table SET title = ?, content = ?, image = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sssi', $this->title, $this->content, $this->image, $this->id);
        return $stmt->execute();
    }

    public function delete() {
        $query_image = "SELECT image FROM $this->table WHERE id = ?";
        $stmt_image = $this->conn->prepare($query_image);
        $stmt_image->bind_param('i', $this->id);
        $stmt_image->execute();
        $result = $stmt_image->get_result();
        $row = $result->fetch_assoc();
        $image = $row['image'];

        $query_comments = "DELETE FROM comments WHERE post_id = ?";
        $stmt_comments = $this->conn->prepare($query_comments);
        $stmt_comments->bind_param('i', $this->id);
        $stmt_comments->execute();

        $query_post = "DELETE FROM $this->table WHERE id = ?";
        $stmt_post = $this->conn->prepare($query_post);
        $stmt_post->bind_param('i', $this->id);
        $stmt_post->execute();

        if ($image && file_exists('../uploads/' . $image)) {
            unlink('../uploads/' . $image);
        }

        return $stmt_post->affected_rows > 0;
    }

}
?>
