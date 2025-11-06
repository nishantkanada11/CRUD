<?php include __DIR__ . '/../layouts/header.php'; ?>
<h2>Users List</h2>

<div class="table-header">
    <a href="index.php?action=create">+ Create User</a>
</div>

<input type="text" id="search" placeholder="Search users...">

<div class="table-wrapper">
    <table border="1" cellpadding="10" id="usersTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr id="row-<?= $user['id']; ?>">
                    <td><?= $user['id']; ?></td>
                    <td><?= htmlspecialchars($user['name']); ?></td>
                    <td><?= htmlspecialchars($user['email']); ?></td>
                    <td><?= htmlspecialchars($user['mobile']); ?></td>
                    <td><?= htmlspecialchars($user['department']); ?></td>
                    <td> <?php $editing = $_GET['editing'] ?? null; ?> 
                    <?php if ($editing != $user['id']): ?> 
                        <a href="index.php?action=edit&id=<?= $user['id']; ?>">Edit</a> 
                        <a href="index.php?action=delete&id=<?= $user['id']; ?>" class="delete-btn" data-id="<?= $user['id']; ?>">Delete</a>
                    <?php endif; ?>
                </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    document.getElementById("search").addEventListener("keyup", function () {
        const query = this.value.trim();
        fetch(`index.php?action=search&query=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(users => {
                const tbody = document.querySelector("#usersTable tbody");
                tbody.innerHTML = "";
                 if (users.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6">
                            No users found
                        </td>
                    </tr>`;
                return;
            }
                users.forEach(user => {
                    tbody.innerHTML += `
                    <tr id="row-${user.id}" \>
                        <td>${user.id}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.mobile}</td>
                        <td>${user.department}</td>
                        <td>
                            <a href="index.php?action=edit&id=${user.id}">Edit</a>
                            <a href="index.php?action=delete&id=${user.id}" class="delete-btn" data-id="${user.id}">Delete</a>
                        </td>
                    </tr>`;
                });
            });
    });
    document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            if (!confirm("Are you sure?")) return;

            let userId = this.getAttribute("data-id");
            let url = this.getAttribute("href");

            fetch(url, { method: "GET" })
                .then(res => res.text())
                .then(() => {
                    document.getElementById("row-" + userId).remove();
                })
                .catch(err => console.log(err));
        });
    });
</script>
<?php include __DIR__ . '/../layouts/footer.php'; ?>