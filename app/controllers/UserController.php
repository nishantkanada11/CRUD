<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $user;

    public function __construct($db)
    {
        $this->user = new User($db);
    }

    // Show all users
    public function index()
    {
        $users = $this->user->all();
        include __DIR__ . '/../views/users/index.php';
    }

    // Show create form
    public function create()
    {
        include __DIR__ . '/../views/users/create.php';
    }

    // Store new user
    public function store()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $department = $_POST['department'];

        $result = $this->user->create($name, $email, $mobile, $department);

        if ($result === "exists") {
            echo "<script>alert('Email or Mobile already exists!'); window.history.back();</script>";
            exit;
        }


        $this->user->create($name, $email, $mobile, $department);
        header('Location: index.php?controller=User&action=index');
        exit;
    }

    // Show edit form
    public function edit()
    {
        $id = $_GET['id'];
        $user = $this->user->find($id);
        include __DIR__ . '/../views/users/edit.php';
    }

    // Update user
public function update() {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $department = $_POST['department'];

    $result = $this->user->update($id, $name, $email, $mobile, $department);

    if ($result === "exists") {
        echo "<script>alert('Email or Mobile already exists!'); window.history.back();</script>";
        exit;
    }

    header("Location: index.php?action=index");
}


    // Delete user
    public function delete()
    {
        $id = $_GET['id'];
        $this->user->delete($id);
        header('Location: index.php?controller=User&action=index');
        exit;
    }
}
