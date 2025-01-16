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
    <h2 style="
        text-align: center; 
        font-size: 1.8em; 
        margin-bottom: 20px; 
        color: #333;">Borrowing Form</h2>

<?php
require 'vendor/autoload.php'; // Include Composer autoloader
use setasign\Fpdi\Fpdi;

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "project"; // Use your database name

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the latest row from the database
$sql = "SELECT * FROM transaction ORDER BY transaction_id DESC LIMIT 1"; // Query to get the latest transaction
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the row data
    $data = $result->fetch_assoc();

    // Define the path to the signature image
    $signaturePath = $data['signature']; // Adjust extension if needed

    // Generate PDF for the latest row
    $pdf = new Fpdi();
    $totalPages = $pdf->setSourceFile('SOK.PYG.BR15_BORANG KEBENARAN PELEPASAN PERALATAN_24122024.pdf');

    for ($page = 1; $page <= $totalPages; $page++) {
        $pdf->AddPage();
        $templateId = $pdf->importPage($page);
        $pdf->useTemplate($templateId);

        // Set font
        $pdf->SetFont('Helvetica', '', 11);

        // Page-specific logic
        if ($page === 1) {
            $pdf->SetXY(55, 54); // Position for "Nama Alat"
            $pdf->Write(0, 'Rujuk Lampiran');

            $pdf->SetXY(55, 64); // Position for "Nama Makmal / Bilik / Tempat"
            $pdf->Write(0, 'Rujuk Lampiran');

	    $pdf->SetXY(74, 74); // Position for "Nama Makmal / Bilik / Tempat"
            $pdf->Write(0, 'Rujuk Lampiran');

	    if ($data['purpose'] == 'Borrowing')
		{ 
	    $pdf->SetXY(110, 95); // Position for "Nama Makmal / Bilik / Tempat"
            $pdf->Write(0, '/');
		}
            $pdf->SetXY(55, 104.5); // Position for "Nama Pengambil"
            $pdf->Write(0, $data['name']);

	    $pdf->SetXY(150, 104.5); // Position for "Nama Pengambil"
            $pdf->Write(0, $data['borrow_date']);

            $pdf->SetXY(63, 114); // Position for "No. IC Pengambil"
            $pdf->Write(0, $data['ic_num']);
	    
	    $pdf->SetXY(140, 114); // Position for "No. IC Pengambil"
            $pdf->Write(0, $data['phone_num']);

	    // Add signature if the file exists
            if (file_exists($signaturePath)) {
                $pdf->Image($signaturePath, 70, 155, 20, 10); // Adjust position and size as needed
            }

        } elseif ($page === 2) {
    	    $pdf->SetFont('Helvetica', 'B', 11);  // Set bold font
            $pdf->SetXY(20, 130); // Position for "Lampiran"
            $pdf->Write(0,'Lampiran');
	    $textWidth = $pdf->GetStringWidth(' Lampiran ');  // Get width of the text
            $pdf->Line(21, 130 + 2, 20 + $textWidth, 130 + 2);  // Draw line beneath text (y + 2 to adjust position)
	    $pdf->SetFont('Helvetica', '', 11);
	    
	    
        }
    }

    // Save the PDF to a file
    $outputFile = 'filled_output.pdf';
    $pdf->Output('F', $outputFile);

    // Provide a preview using an iframe
    echo "<h3>Preview the Form:</h3>";
    echo "<iframe src='$outputFile' width='100%' height='600px'></iframe><br><br>";

    // Generate download link
    echo "If everything looks good, download the form: <a href='$outputFile' download>Download</a><br>";
} else {
    echo "No data found in the database.";
}

$conn->close();

?>
</div>


<div class="footer">
    &copy; 2025 Copyright. All Rights Reserved. | by GROUP 1
</div>
</body>
</html>

