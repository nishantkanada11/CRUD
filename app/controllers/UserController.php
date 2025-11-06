<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $user;

    public function __construct($db)
    {
        $this->user = new User($db);
    }


    public function index()
    {
        $users = $this->user->all();
        include __DIR__ . '/../views/users/index.php';
    }

    public function search()
    {
        $query = $_GET['query'] ?? '';
        $results = $this->user->search($query);
        echo json_encode($results);
    }

    public function create()
    {
        include __DIR__ . '/../views/users/create.php';
    }


    public function store()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $department = $_POST['department'];

        $result = $this->user->create($name, $email, $mobile, $department);

        if ($result === "invalid_email") {
            echo json_encode(["success" => false, "message" => "Invalid email format"]);
        } elseif ($result === "invalid_mobile") {
            echo json_encode(["success" => false, "message" => "Mobile number must be 10 digits"]);
        } elseif ($result === "exists") {
            echo json_encode(["success" => false, "message" => "Email or mobile already exists"]);
        } elseif ($result === "invalid_name") {
            echo json_encode(["success" => false, "message" => "Check your naem"]);
        } elseif ($result) {
            echo json_encode(["success" => true, "message" => "User created successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to create user"]);
        }
        exit;

    }

    public function edit()
    {
        $id = $_GET['id'];
        $user = $this->user->find($id);
        include __DIR__ . '/../views/users/edit.php';
    }


    public function update()
    {

        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $department = $_POST['department'];

        $result = $this->user->update($id, $name, $email, $mobile, $department);

        if ($result === "invalid_email") {
            echo json_encode(["success" => false, "message" => "Invalid email format"]);
        } elseif ($result === "invalid_mobile") {
            echo json_encode(["success" => false, "message" => "Mobile number must be 10 digits"]);
        } elseif ($result === "exists") {
            echo json_encode(["success" => false, "message" => "Email or mobile already exists"]);
        } elseif ($result === "invalid_name") {
            echo json_encode(["success" => false, "message" => "Check your name"]);
        } elseif ($result) {
            echo json_encode(["success" => true, "message" => "Use Updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to create user"]);
        }
    }

    public function delete()
    {
        $id = $_GET['id'];
        $this->user->delete($id);
        echo json_encode([
            "success" => true,
            "message" => "User Delete"
        ]);
    }
}