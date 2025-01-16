<?php
session_start();

include 'db.php';

if (empty($_SESSION['cart'])) {
    echo "No items in the cart.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'update') {
            foreach ($_SESSION['cart'] as $key => $item) {
                if (isset($_POST['quantity'][$item['equip_id']]) && $_POST['quantity'][$item['equip_id']] > 0) {
                    $_SESSION['cart'][$key]['quantity'] = $_POST['quantity'][$item['equip_id']];
                }
            }
        } elseif ($_POST['action'] === 'remove') {
            if (isset($_POST['equip_id'])) {
                foreach ($_SESSION['cart'] as $key => $item) {
                    if ($item['equip_id'] == $_POST['equip_id']) {
                        unset($_SESSION['cart'][$key]);
                        break;
                    }
                }
                $_SESSION['cart'] = array_values($_SESSION['cart']);
            }
        } elseif ($_POST['action'] === 'proceed') {
            foreach ($_SESSION['cart'] as $item) {
                $equip_id = $item['equip_id'];
                $quantity = $item['quantity'];

                // Fix: Use correct column name (quantity) in the query
                $sql = "UPDATE equipment SET quantity = quantity - ? WHERE equip_id = ? AND quantity >= ?";
                $stmt = $conn->prepare($sql);
                
                // Debugging: Check if query preparation succeeded
                if (!$stmt) {
                    die("SQL Error: " . $conn->error);
                }

                $stmt->bind_param('iii', $quantity, $equip_id, $quantity);
                $stmt->execute();

                if ($stmt->affected_rows === 0) {
                    echo "Error: Not enough stock for item ID {$equip_id}.";
                    exit();
                }
            }

            unset($_SESSION['cart']);
            header("Location: fill_pdf.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Summary</title>
    <link rel="stylesheet" href="cart.css?v=<?php echo time(); ?>">
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
        <button onclick="location.href='admin_login.html'" class="admin-btn">Admin Login</button>
        <div>
            <button class="language-select" onclick="changeLanguage('bm')">BM</button> /
            <button class="language-select" onclick="changeLanguage('eng')">ENG</button>
        </div>
    </div>
</header>
<div class="container">
    <h2>Cart Summary</h2>
    <form action="cart-summary.php" method="POST">
        <table>
            <thead>
                <tr>
                    <th>Equipment</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($_SESSION['cart'])) {
                    include 'db.php';
                    foreach ($_SESSION['cart'] as $key => $item) {
                        $equip_id = $item['equip_id'];
                        $quantity = $item['quantity'];

                        $sql = "SELECT equip_name FROM equipment WHERE equip_id = $equip_id";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();

                        echo "
                            <tr>
                                <td>{$row['equip_name']}</td>
                                <td>
                                    <input type='number' name='quantity[{$equip_id}]' value='{$quantity}' min='1' max='10' required>
                                </td>
                                <td>
                                    <form action='cart-summary.php' method='POST' style='display:inline;'>
                                        <input type='hidden' name='equip_id' value='{$equip_id}'>
                                        <button type='submit' name='action' value='remove'>Remove</button>
                                    </form>
                                </td>
                            </tr>
                        ";
                    }
                    $conn->close();
                }
                ?>
            </tbody>
        </table>
        <button type="submit" class="submit-btn" name="action" value="proceed">Proceed to Borrow</button>
    </form>
</div>
<footer>
    &copy; 2025 Copyright. All Rights Reserved. | by GROUP 1
</footer>
</body>
</html>
