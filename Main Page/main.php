<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Inventory</title>
    <link rel="stylesheet" href="main.css?v=<?php echo time(); ?>">

</head>
<header>
    <div class="logo">
    <a href="main.php">
    <img src="./images/logo.png" alt="Logo">
    </a>
    </div>
    <div class="title" id="header-title">CCSE LAB EQUIPMENT BOOKING SYSTEM</div>
    <div class="auth-language">
    <button onclick="location.href='main.php'" class="home-btn">Home</button>
    <button id="admin-btn" onclick="location.href='admin_login.html'" class="admin-btn">Admin Login</button>
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

    <div class="content">
            <div class="search-bar">
                <form method="GET" action="search-results.php">
                    <input type="text" name="search" placeholder="Search the equipment" required>
                    <button type="submit" id="search-button" class="search-button">Search</button>

                </form>
             </div>


        <div class="equipment-list">
            <div class="equipment-list">
                <?php
                include 'db.php';
            
                $sql = "SELECT * FROM equipment";
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
                    echo "<p>No equipment found.</p>";
                }

                $conn->close();
                ?>
            </div>
        </div>

        <div class="pagination">
            <a href="#">&lt;</a>
            <a href="#">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">&gt;</a>
        </div>
    </div>
</div>
<footer>
    &copy; <a >2025 Copyright. All Rights Reserved. | by GROUP 1</a>
</footer>
<script src="script.js"></script>
</body>
</html>
