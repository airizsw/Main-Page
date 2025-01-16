<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin-dashboard.css?v=<?php echo time(); ?>">
    <!-- Font Awesome CDN for icons -->
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
        <div class="grid">
            <div class="card">
                <h2>Total Users</h2>
                <p>150</p>
            </div>
            <div class="card">
                <h2>Equipment Available</h2>
                <p>85</p>
            </div>
            <div class="card">
                <h2>Pending Requests</h2>
                <p>12</p>
            </div>
        </div>
        <div class="table-container">
        <h2>Manage Records</h2>
        <button onclick="document.getElementById('addEquipmentModal').style.display='block'">Add New Equipment</button>

        <!-- Add Equipment Modal -->
        <div id="addEquipmentModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background-color:white; border:1px solid #ccc; padding:20px; z-index:1000;">
            <h3>Add New Equipment</h3>
            <form action="add-equipment.php" method="POST" enctype="multipart/form-data">
                <label for="equip_name">Equipment Name:</label>
                <input type="text" id="equip_name" name="equip_name" required><br><br>

                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required><br><br>

                <label for="location">Location:</label>
                <input type="text" id="location" name="location" required><br><br>

                <label for="pic">Person In Charge:</label>
                <input type="text" id="pic" name="pic" required><br><br>

                <label for="picture">Upload Picture:</label>
                <input type="file" id="picture" name="picture" accept="image/*"><br><br>

                <button type="submit">Add Equipment</button>
                <button type="button" onclick="document.getElementById('addEquipmentModal').style.display='none'">Cancel</button>
            </form>
        </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Location</th>
                        <th>Picture</th>
                        <th>Person In Charge</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include 'fetch-equipment.php'; ?>
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
