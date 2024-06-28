<?php

class Log {
    private $conn;
    private $table = 'logs';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function add_log($user_id, $action) {
        $query = "INSERT INTO {$this->table} (user_id, action) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('is', $user_id, $action);
        $stmt->execute();
    }

    public function read_all() {
        $query = "SELECT logs.user_id, logs.action, logs.timestamp, users.username 
                  FROM {$this->table} 
                  JOIN users ON logs.user_id = users.id 
                  ORDER BY logs.timestamp DESC";
        $result = $this->conn->query($query);
        return $result;
    }
}

?>
