<?php

session_start();
include 'db.php';


// Retrieve form data
$admin_username = trim($_POST['username']);
$admin_password = trim($_POST['password']);

// Use a prepared statement to prevent SQL injection
$sql = "SELECT * FROM admin WHERE username = ?";
$stmt = $conn->prepare($sql);

// Check if query preparation was successful
if (!$stmt) {
    die("Error in SQL query: " . $conn->error);
}

// Bind the username parameter and execute the statement
$stmt->bind_param("s", $admin_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();

    // Check if the password is plain text or hashed
    if (password_verify($admin_password, $admin['password']) || $admin_password === $admin['password']) {
        // Set session variable and redirect to the dashboard
        $_SESSION['admin_username'] = $admin['username'];
        header("Location: admin-dashboard.php");
        exit();
    } else {
        // Incorrect password
        echo "<script>
                alert('Incorrect username or password!');
                window.location.href = 'admin_login.html';
              </script>";
    }
} else {
    // Username not found
    echo "<script>
            alert('Incorrect username or password!');
            window.location.href = 'admin_login.html';
          </script>";
}

// Close the connection
$stmt->close();
$conn->close();
?>
