<?php
    include 'db.php';

    // Check if a search term is provided
    $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
    $searchQuery = '';

    if ($searchTerm) {
        // Split the search term into individual keywords
        $keywords = explode(' ', $searchTerm);

        // Build a robust WHERE clause
        $searchParts = [];
        foreach ($keywords as $keyword) {
            $searchParts[] = "(equip_name LIKE '%$keyword%' OR location LIKE '%$keyword%')";
        }
        $searchQuery = 'WHERE ' . implode(' AND ', $searchParts);
    }

    // Fetch equipment data with the search query
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
        echo "<p>No equipment found.</p>";
    }

    $conn->close();
    ?>