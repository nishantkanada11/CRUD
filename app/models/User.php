<?php

class User
{
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function all()
    {
        $res = $this->conn->query("SELECT * FROM users ORDER BY id DESC");
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function search($keyword)
    {
        $keyword = "%" . $keyword . "%";
        $stmt = $this->conn->prepare("
            SELECT * FROM users 
            WHERE CONCAT(id,name, email, mobile, department) LIKE ?
            ORDER BY id DESC
        ");
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
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
        $name = ucfirst($name);
        if ((!preg_match("/^[a-zA-Z ]*$/", $name))) {
            return "invalid_name";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "invalid_email";
        }

        if (!preg_match('/^[0-9]{10,}$/', $mobile)) {
            return "invalid_mobile";
        }
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
        if ($stmt->execute()) {
            return true;
        }

    }

    public function update($id, $name, $email, $mobile, $department)
    {
        $name = ucfirst($name);
        if ((!preg_match("/^[a-zA-Z ]*$/", $name))) {
            return "invalid_name";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "invalid_email";
        }

        if (!preg_match('/^[0-9]{10,}$/', $mobile)) {
            return "invalid_mobile";
        }

        $stmt = $this->conn->prepare(
            "SELECT id FROM users 
         WHERE (TRIM(email)=? OR TRIM(mobile)=?) AND id!=?"
        );
        $stmt->bind_param("sii", $email, $mobile, $id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            return "exists";
        }
        $stmt = $this->conn->prepare(
            "UPDATE users 
         SET name=?, email=?, mobile=?, department=?
         WHERE id=?"
        );
        $stmt->bind_param("ssisi", $name, $email, $mobile, $department, $id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}