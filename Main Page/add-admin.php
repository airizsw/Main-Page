<?php
session_start();
include 'db.php';

// Retrieve form data
$email = trim($_POST['email']);
$username = trim($_POST['username']);
$password = trim($_POST['password']);

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if the username or email already exists
$sql_check = "SELECT * FROM admin WHERE username = ? OR email = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ss", $username, $email);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "<script>
            alert('Username or email already exists!');
            window.location.href = 'add-admin.html';
          </script>";
    exit();
}

// Insert new admin into the database
$sql_insert = "INSERT INTO admin (username, password, email) VALUES (?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);

// Check if query preparation was successful
if (!$stmt_insert) {
    die("Error in SQL query: " . $conn->error);
}

// Bind parameters and execute the statement
$stmt_insert->bind_param("sss", $username, $hashed_password, $email);
if ($stmt_insert->execute()) {
    echo "<script>
            alert('Admin added successfully!');
            window.location.href = 'admin-dashboard.php';
          </script>";
} else {
    echo "<script>
            alert('Error adding admin. Please try again.');
            window.location.href = 'add-admin.html';
          </script>";
}

// Close connections
$stmt_check->close();
$stmt_insert->close();
$conn->close();
?>