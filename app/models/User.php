<?php

class User {
    private $conn;

    // Constructor receives the DB connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all users
    public function all() {
        $res = $this->conn->query("SELECT * FROM users ORDER BY id DESC");
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Find a user by ID
    public function find($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Create a new user
public function create($name, $email, $mobile, $department) {
    // Check if email exists already
    $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        // Email already exists
        return "exists";
    }

    // Insert if not exists
    $stmt = $this->conn->prepare(
        "INSERT INTO users (name, email, mobile, department) VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("ssss", $name, $email, $mobile, $department);
    return $stmt->execute();
}


    // Update a user
public function update($id, $name, $email, $mobile, $department) {
    // Check if email is already used by another user
    $stmt = $this->conn->prepare(
        "SELECT id FROM users WHERE email = ? AND id != ?"
    );
    $stmt->bind_param("si", $email, $id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        // Email already exists for another user
        return "exists";
    }

    // Update if not exists
    $stmt = $this->conn->prepare(
        "UPDATE users SET name = ?, email = ?, mobile = ?, department = ? WHERE id = ?"
    );
    $stmt->bind_param("ssssi", $name, $email, $mobile, $department, $id);
    return $stmt->execute();
}


    // Delete a user
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
