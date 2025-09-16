<?php include __DIR__ . '/../layouts/header.php'; ?>
<div class="table-header">
    <a href="index.php">Home</a>
</div>

<h2>Create New User</h2>

<form method="POST" action="index.php?action=store">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Mobile:</label><br>
    <input type="number" name="mobile" required><br><br>

    <label>Department:</label><br>
    <input type="text" name="department" required><br><br>

    <button type="submit">Create</button>
</form>

<?php include __DIR__ . '/../layouts/footer.php'; ?>