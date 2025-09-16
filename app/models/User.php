<?php

class User
{
    private $conn;

    // Constructor receives the DB connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function all()
    {
        $res = $this->conn->query("SELECT * FROM users ORDER BY id DESC");
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function find($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($name, $email, $mobile, $department)
    {

        $stmt = $this->conn->prepare(
            "SELECT id FROM users WHERE (TRIM(email) = ? OR TRIM(mobile) = ?)"
        );
        $stmt->bind_param("si", $email, $mobile);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            return "exists";
        }

        $stmt = $this->conn->prepare(
            "INSERT INTO users (name, email, mobile, department) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssis", $name, $email, $mobile, $department);
        return $stmt->execute();
    }

    public function update($id, $name, $email, $mobile, $department)
    {
        $stmt = $this->conn->prepare(
            "SELECT id FROM users 
         WHERE (TRIM(email) = ? OR TRIM(mobile) = ?) AND id != ?"
        );
        $stmt->bind_param("sii", $email, $mobile, $id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            return "exists";
        }

        $stmt = $this->conn->prepare(
            "UPDATE users 
         SET name = ?, email = ?, mobile = ?, department = ? 
         WHERE id = ?"
        );
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
