<?php
include 'db.php';

if (isset($_GET['id'])) {
    $equip_id = $_GET['id'];

    $sql = "DELETE FROM equipment WHERE equip_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $equip_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Equipment deleted successfully.');
                window.location.href = 'admin-dashboard.php';
              </script>";
    } else {
        echo "Error deleting equipment: " . $conn->error;
    }
} else {
    echo "Invalid request.";
    exit();
}
?>
