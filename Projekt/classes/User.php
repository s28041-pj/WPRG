<?php

class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $username;
    public $email;
    public $password;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO $this->table (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssss', $this->username, $this->email, $this->password, $this->role);
        return $stmt->execute();
    }

    public function authenticate() {
        $query = "SELECT id, password, role FROM $this->table WHERE username = ? OR email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ss', $this->username, $this->username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($this->id, $hashed_password, $this->role);
        if ($stmt->num_rows > 0 && $stmt->fetch()) {
            return password_verify($this->password, $hashed_password);
        }
        return false;
    }

    public function reset_password() {
        $query = "UPDATE $this->table SET password = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('si', $this->password, $this->id);
        return $stmt->execute();
    }
    public function read_all() {
        $query = "SELECT id, username, role FROM $this->table ORDER BY username";
        return $this->conn->query($query);
    }

    public function read_by_id($id) {
        $query = "SELECT * FROM $this->table WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update_role() {
        $query = "UPDATE $this->table SET role = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('si', $this->role, $this->id);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM $this->table WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $this->id);
        return $stmt->execute();
    }
}
?>
