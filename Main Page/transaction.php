<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="transaction.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<header style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px;">
    <a href="main.php" class="exit-button">
        <button style="background-color: #808080; border: 1px solid #ccc; padding: 8px 15px; font-size: 16px; cursor: pointer; border-radius: 5px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
            <i class="fas fa-home" style="margin-right: 8px;"></i> Exit
        </button>
    </a>
    <div class="title" id="header-title">ADMIN DASHBOARD</div>
</header>

    <nav>
        <ul>
            <li><a href="admin-dashboard.php">Dashboard</a></li>
            <li><a href="transaction.php">Transaction</a></li>
            <li><a href="equipment.php">Equipment</a></li>
            <li><a href="#">Reports</a></li>
            <li><a href="#">Settings</a></li>
            <button onclick="location.href='add-admin.html'" class="admin-btn">Add Admin</button>
        </ul>
    </nav>
    <main>
        <h1>Welcome, Admin</h1>
        <div class="table-container">
        <h2>Manage Transaction</h2>

            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Equipment ID</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include 'fetch-transaction.php'; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

<script>
function deleteEquipment(id) {
    if (confirm('Are you sure you want to delete this equipment?')) {
        window.location.href = `delete-equipment.php?id=${id}`;
    }
}
</script>

</html>
