<?php
session_start(); // Start the session
include 'db.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ic_num = $_POST['user_id'] ?? ''; // Collect IC number
    $borrow_date = $_POST['borrow_date'] ?? ''; 
    $name = $_POST['name'] ?? '';
    $phone_num = $_POST['phone_num'] ?? '';
    $purpose = isset($_POST['purpose']) ? implode(", ", $_POST['purpose']) : ''; // Concatenate checkbox values

    // Handle signature upload
    $signature = '';
    if (isset($_FILES['signature']) && $_FILES['signature']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'signature/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $signatureFile = $uploadDir . basename($_FILES['signature']['name']);
        if (move_uploaded_file($_FILES['signature']['tmp_name'], $signatureFile)) {
            $signature = $signatureFile;
        } else {
            echo "Error: Failed to upload signature.";
            exit();
        }
    }

    // Validate fields and insert into the database
    if (!empty($ic_num) && !empty($borrow_date) && !empty($name) && !empty($phone_num) && !empty($signature) && !empty($purpose)) {
        $stmt = $conn->prepare("INSERT INTO transaction (ic_num, borrow_date, name, phone_num, signature, purpose)
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $ic_num, $borrow_date, $name, $phone_num, $signature, $purpose);
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $ic_num; // Store IC number in the session
            header("Location: selection-form.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: Please fill out all required fields.";
    }
    $conn->close();
}
?>
