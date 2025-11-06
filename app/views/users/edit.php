<?php include __DIR__ . '/../layouts/header.php'; ?>
<div class="table-header">
    <a href="index.php">Home</a>
</div>
<h2>Edit User</h2>
<?php $editUser = $user['id']; ?>

<form method="POST" action="index.php?action=update" id="editForm">
    <input type="hidden" name="id" value="<?= $user['id']; ?>">

    <label>Name:</label><br>
    <input type="text" name="name" value="<?= $user['name']; ?>" required><br><br>

    <label>Email:</label><br>
    <input type="text" name="email" value="<?= $user['email']; ?>" required><br><br>

    <label>Mobile:</label><br>
    <input type="number" name="mobile" value="<?= $user['mobile']; ?>" required><br><br>

    <label>Department:</label><br>
    <input type="text" name="department" value="<?= $user['department']; ?>" required><br><br>

    <button type="submit">Update</button>
</form>

<div id="message" style="color:green; margin-top:10px;"></div>

<script>
    document.getElementById("editForm").addEventListener("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        fetch(this.action, {
            method: "POST",
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                document.getElementById("message").textContent = data.message;
                if (data.success) {
                    window.location.href = "index.php?action=index";
                    loadUsers();
                }
            });
    });

    function loadUsers() {
        fetch("index.php?action=index&editing=<?= $editUser; ?>")
            .then(res => res.text())
            .then(html => {
                document.getElementById("userList").innerHTML = html;

                document.querySelectorAll(".delete-btn").forEach(btn => {
                    btn.addEventListener("click", function (e) {
                        e.preventDefault();

                        if (!confirm("Are you sure?")) return;
                        let id = this.dataset.id;

                        fetch("index.php?action=delete&id=" + id)
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    loadUsers();
                                }
                            });
                    });
                });
            });
    }
    loadUsers();

</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>