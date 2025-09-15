<?php include __DIR__ . '/../layouts/header.php'; ?>

<h2>Users List</h2>
<div class="table-header">
        <a href="index.php?action=create" class="add-btn">+ Create User</a>
    </div>


<div class="table-wrapper">
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Department</th>
        <th>Actions</th>
    </tr>

    <?php foreach($users as $user): ?>
    <tr>
        <td><?= $user['id']; ?></td>
        <td><?= $user['name']; ?></td>
        <td><?= $user['email']; ?></td>
        <td><?= $user['mobile']; ?></td>
        <td><?= $user['department']; ?></td>
        <td>
            <a href="index.php?action=edit&id=<?= $user['id']; ?>">Edit</a> |
            <a href="index.php?action=delete&id=<?= $user['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
