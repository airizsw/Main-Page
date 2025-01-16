<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the cart is populated
    if (!empty($_POST['equipments']) && !empty($_POST['quantities'])) {
        $_SESSION['cart'] = []; // Initialize the cart
        $equipments = $_POST['equipments'];
        $quantities = $_POST['quantities'];

        // Validate and populate the cart
        foreach ($equipments as $equip_id) {
            if (isset($quantities[$equip_id]) && $quantities[$equip_id] > 0) {
                $_SESSION['cart'][] = [
                    'equip_id' => $equip_id,
                    'quantity' => $quantities[$equip_id]
                ];
            }
        }

        if (!empty($_SESSION['cart'])) {
            header("Location: cart-summary.php"); // Redirect to summary
            exit();
        } else {
            echo "No items added to the cart.";
        }
    } else {
        echo "No items selected. Please select at least one equipment.";
    }
} else {
    echo "Invalid request method.";
}
?>
