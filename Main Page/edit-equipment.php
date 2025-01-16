<?php
include 'db.php';

if (isset($_GET['id'])) {
    $equip_id = $_GET['id'];

    // Fetch the equipment details
    $sql = "SELECT * FROM equipment WHERE equip_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $equip_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $equipment = $result->fetch_assoc();
    } else {
        echo "Equipment not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

// Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equip_name = trim($_POST['equip_name']);
    $quantity = (int)$_POST['quantity'];
    $location = trim($_POST['location']);
    $pic = trim($_POST['pic']);
    $picture_name = $equipment['picture']; // Keep the current image by default

    // Handle file upload if a new picture is provided
    if (!empty($_FILES['picture']['name'])) {
        // Define the target directory for uploaded files
        $target_dir = "uploads/";
        $picture_name = basename($_FILES['picture']['name']);
        $target_file = $target_dir . $picture_name;

        // Delete the old image if a new one is uploaded
        $old_image_path = $target_dir . $equipment['picture'];
        if (file_exists($old_image_path)) {
            unlink($old_image_path); // Delete old image
        }

        // Validate and move uploaded file
        if (move_uploaded_file($_FILES['picture']['tmp_name'], $target_file)) {
            echo "Picture uploaded successfully.";
        } else {
            echo "Error uploading picture.";
        }
    }

    // Update the equipment details in the database
    $sql = "UPDATE equipment SET equip_name = ?, quantity = ?, location = ?, picture = ?, pic = ? WHERE equip_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssi", $equip_name, $quantity, $location, $picture_name, $pic, $equip_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Equipment updated successfully.');
                window.location.href = 'admin-dashboard.php';
            </script>";
    } else {
        echo "Error updating equipment: " . $conn->error;
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Equipment</title>
    <link rel="stylesheet" href="edit-style.css?v=1.0">
</head>
<body>
    <h2>Edit Equipment</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="equip_name">Equipment Name:</label>
        <input type="text" id="equip_name" name="equip_name" value="<?php echo htmlspecialchars($equipment['equip_name']); ?>" required><br><br>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="<?php echo $equipment['quantity']; ?>" required><br><br>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($equipment['location']); ?>" required><br><br>

        <label for="pic">Person In Charge:</label>
        <input type="text" id="pic" name="pic" value="<?php echo htmlspecialchars($equipment['pic']); ?>" required><br><br>

        <label for="picture">Upload Picture (Leave empty to keep the current picture):</label>
        <input type="file" id="picture" name="picture" accept="image/*"><br><br>

        <!-- Display the current image -->
        <img src="uploads/<?php echo $equipment['picture']; ?>" alt="Current Equipment Image" width="100"><br><br>

        <button type="submit">Update</button>
        <a href="admin-dashboard.php"><button type="button">Cancel</button></a>
    </form>
</body>
</html>
