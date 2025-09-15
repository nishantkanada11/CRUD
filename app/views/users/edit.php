<?php include __DIR__ . '/../layouts/header.php'; ?>
<a href="index.php">Home</a>
<h2>Edit User</h2>

<form method="POST" action="index.php?action=update">
    <input type="hidden" name="id" value="<?= $user['id']; ?>">

    <label>Name:</label><br>
    <input type="text" name="name" value="<?= $user['name']; ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= $user['email']; ?>" required><br><br>

    <label>Mobile:</label><br>
    <input type="text" name="mobile" value="<?= $user['mobile']; ?>" required><br><br>

    <label>Department:</label><br>
    <input type="text" name="department" value="<?= $user['department']; ?>" required><br><br>

    <button type="submit">Update</button>
</form>

<?php include __DIR__ . '/../layouts/footer.php'; ?>