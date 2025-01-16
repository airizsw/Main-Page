<?php
session_start();
include 'db.php';

// Query the equipment table
$sql = "SELECT * FROM equipment";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['equip_id']}</td>
                <td>{$row['equip_name']}</td>
                <td>{$row['quantity']}</td>
                <td>{$row['location']}</td>
                <td><img src='uploads/{$row['picture']}' alt='Equipment Image' width='50'></td>
                <td>{$row['pic']}</td>
                <td class='actions'>
                <a href='edit-equipment.php?id={$row['equip_id']}'><button>Edit</button></a>
                <button onclick=\"deleteEquipment({$row['equip_id']})\">Delete</button>
            </td>
            
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No records found</td></tr>";
}

// Close the database connection
$conn->close();
?>