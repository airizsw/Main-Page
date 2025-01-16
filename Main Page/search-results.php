<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="main.css?v=<?php echo time(); ?>">
</head>
<body>
<header>
    <div class="logo">
    <a href="main.php">
    <img src="./images/logo.png" alt="Logo">
    </a>
    </div>
    <div class="title" id="header-title">CCSE LAB EQUIPMENT BOOKING SYSTEM</div>
    <div class="auth-language">
        <button onclick="location.href='main.php'" class="home-btn">Home</button>
        <button onclick="location.href='admin_login.html'" class="admin-btn">Admin Login</button>
        <div>
            <button class="language-select" onclick="changeLanguage('bm')">BM</button> /
            <button class="language-select" onclick="changeLanguage('eng')">ENG</button>
        </div>
    </div>
</header>
<div class="container">
    <div class="sidebar">
        <h3>Laboratories</h3>
        <ul>
            <li><a href="../Main Page/Computer and Embedded Systems Engineering Laboratory/test.html">Computer & Embedded Systems Engineering Laboratory</a></li>
            <li><a href="../Main Page/Multimedia Systems Engineering Laboratory/test.html">Multimedia Systems Engineering Laboratory</a></li>
            <li><a href="../Main Page/Intelligent Systems Engineering Laboratory/test.html">Intelligent Systems Engineering Laboratory</a></li>
            <li><a href="../Main Page/Computer & Communication Systems Engineering Workshop/test.html">Computer & Communication Systems Engineering Workshop</a></li>
        </ul>
        <h3>Applications</h3>
        <ul>
            <li><a href="uform.html">Application Form</a></li>
        </ul>
    </div>

<div class="container">
    <div class="content">
        <h3>Search Results</h3>
        <div class="equipment-list">
            <?php
            include 'db.php'; // Include database connection

            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $searchTerm = trim($_GET['search']);
                $keywords = explode(' ', $searchTerm);

                // Construct search query
                $searchParts = [];
                foreach ($keywords as $keyword) {
                    $searchParts[] = "(equip_name LIKE '%$keyword%' OR location LIKE '%$keyword%')";
                }
                $searchQuery = 'WHERE ' . implode(' AND ', $searchParts);

                $sql = "SELECT * FROM equipment $searchQuery";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <div class='equipment-item'>
                            <img src='uploads/{$row['picture']}' alt='{$row['equip_name']}' />
                            <h4>{$row['equip_name']}</h4>
                            <p>Location: {$row['location']}</p>
                            <p>Available Units: {$row['quantity']}</p>
                        </div>
                        ";
                    }
                } else {
                    echo "<p>No equipment found for '$searchTerm'.</p>";
                }
            } else {
                echo "<p>Invalid search term. Please try again.</p>";
            }

            $conn->close(); // Close database connection
            ?>
        </div>
        <div class="back-btn">
        <button class="back-to-home-btn" onclick="location.href='main.php'">Back to Home</button>
        </div>
    </div>
</div>

<footer>
    &copy; <a>2025 Copyright. All Rights Reserved. | by GROUP 1</a>
</footer>
</body>
</html>
