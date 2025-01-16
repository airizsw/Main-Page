<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Equipment</title>
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
    <h2 style="
        text-align: center; 
        font-size: 1.8em; 
        margin-bottom: 20px; 
        color: #333;">Select Equipment</h2>
    <?php
    include 'db.php';

    $sql = "SELECT * FROM equipment";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<form action="process-selection.php" method="POST" style="display: inline-block; width: 100%;">';
        while ($row = $result->fetch_assoc()) {
            echo "
                <div class='equipment-item' style='
                    width: 250px; 
                    border: 1px solid #ccc; 
                    border-radius: 8px; 
                    margin: 15px; 
                    padding: 15px; 
                    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
                    text-align: center; 
                    display: inline-block; 
                    vertical-align: top; 
                    background-color: #f9f9f9;'>
                    <img src='uploads/{$row['picture']}' alt='{$row['equip_name']}' style='
                        width: 100%; 
                        height: 150px; 
                        object-fit: cover; 
                        border-radius: 5px; 
                        margin-bottom: 10px;'>
                    <h4 style='
                        font-size: 1.2em; 
                        color: #333; 
                        margin-bottom: 10px;'>{$row['equip_name']}</h4>
                    <p style='
                        font-size: 0.9em; 
                        color: #666; 
                        margin-bottom: 10px;'>Location: {$row['location']}</p>
                    <p style='
                        font-size: 0.9em; 
                        color: #666; 
                        margin-bottom: 10px;'>Available Units: {$row['quantity']}</p>
                    <label for='quantity_{$row['equip_id']}' style='
                        font-size: 0.9em; 
                        color: #333;'>Quantity:</label>
                    <input type='number' name='quantities[{$row['equip_id']}]' id='quantity_{$row['equip_id']}' min='1' max='{$row['quantity']}' required style='
                        width: 60px; 
                        padding: 5px; 
                        margin: 10px 0; 
                        border: 1px solid #ccc; 
                        border-radius: 4px;'>
                    <button type='button' class='add-to-cart' data-id='{$row['equip_id']}' style='
                        background-color: #007bff; 
                        color: white; 
                        border: none; 
                        padding: 8px 12px; 
                        border-radius: 4px; 
                        cursor: pointer; 
                        margin-top: 10px;'>Add to Cart</button>
                    <input type='hidden' name='equipments[]' value='{$row['equip_id']}'>
                </div>
            ";
        }
        echo '<button type="submit" class="submit-btn" style="
            display: block; 
            margin: 20px auto; 
            padding: 10px 20px; 
            background-color: #28a745; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            font-size: 1.1em; 
            cursor: pointer;">Proceed</button></form>';
    } else {
        echo "<p style='
            text-align: center; 
            color: #888; 
            font-size: 1.2em;'>No equipment found.</p>";
    }

    $conn->close();
    ?>
</div>
<footer>
    &copy; 2025 Copyright. All Rights Reserved. | by GROUP 1
</footer>
<script src="selection.js"></script>
</body>
</html>
