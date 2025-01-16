<?php
session_start();
include 'db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $equip_name = trim($_POST['equip_name']);
    $quantity = (int)$_POST['quantity'];
    $location = trim($_POST['location']);
    $pic = trim($_POST['pic']);
    $picture_name = "";

    // Handle file upload
    if (!empty($_FILES['picture']['name'])) {
        $target_dir = "uploads/";
        $picture_name = basename($_FILES['picture']['name']);
        $target_file = $target_dir . $picture_name;

        // Validate and move uploaded file
        if (move_uploaded_file($_FILES['picture']['tmp_name'], $target_file)) {
            echo "Picture uploaded successfully.";
        } else {
            echo "Error uploading picture.";
        }
    }

    // Insert data into the equipment table
    $sql = "INSERT INTO equipment (equip_name, quantity, location, pic, picture) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sisss", $equip_name, $quantity, $location, $pic, $picture_name);
        if ($stmt->execute()) {
            echo "<script>
                    alert('Equipment added successfully.');
                    window.location.href = 'admin-dashboard.php';
                  </script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing SQL: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>