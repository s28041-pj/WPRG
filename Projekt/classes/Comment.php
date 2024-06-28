<?php

class Comment {
    private $conn;
    private $table = 'comments';

    public $id;
    public $post_id;
    public $user_id;
    public $content;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO $this->table (post_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('iis', $this->post_id, $this->user_id, $this->content);
        return $stmt->execute();
    }

    public function read_by_post($post_id) {
        $query = "SELECT * FROM $this->table WHERE post_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $post_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
