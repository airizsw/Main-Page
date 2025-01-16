<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
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
        <h2>Manage Equipments</h2>
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
