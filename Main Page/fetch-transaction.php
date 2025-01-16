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

// Fetch all rows from the transaction table
$sql = "SELECT * FROM transaction"; // Query to get all transactions
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $fileList = []; // Array to store generated file names

    while ($data = $result->fetch_assoc()) {
        // Define the path to the signature image
        $signaturePath = $data['signature']; // Adjust extension if needed

        // Generate PDF for the current row
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

                if ($data['purpose'] == 'Borrowing') { 
                    $pdf->SetXY(110, 95); // Position for "Nama Makmal / Bilik / Tempat"
                    $pdf->Write(0, '/');
                }

                $pdf->SetXY(55, 104.5); // Position for "Nama Pengambil"
                $pdf->Write(0, $data['name']);

                $pdf->SetXY(150, 104.5); // Position for Borrow Date
                $pdf->Write(0, $data['borrow_date']);

                $pdf->SetXY(63, 114); // Position for "No. IC Pengambil"
                $pdf->Write(0, $data['ic_num']);
                
                $pdf->SetXY(140, 114); // Position for "Phone Number"
                $pdf->Write(0, $data['phone_num']);

                // Add signature if the file exists
                if (file_exists($signaturePath)) {
                    $pdf->Image($signaturePath, 70, 155, 20, 10); // Adjust position and size as needed
                }

            } elseif ($page === 2) {
                $pdf->SetFont('Helvetica', 'B', 11);  // Set bold font
                $pdf->SetXY(20, 130); // Position for "Lampiran"
                $pdf->Write(0, 'Lampiran');
                $textWidth = $pdf->GetStringWidth(' Lampiran ');  // Get width of the text
                $pdf->Line(21, 130 + 2, 20 + $textWidth, 130 + 2);  // Draw line beneath text (y + 2 to adjust position)
                $pdf->SetFont('Helvetica', '', 11);
            }
        }

        // Save the PDF to a file
        $outputFile = 'filled_output_' . $data['transaction_id'] . '.pdf';
        $pdf->Output('F', $outputFile);

        // Add file name to the list
        $fileList[] = $outputFile;
    }

    // Display the list of generated files
    echo "<h3>Generated Forms:</h3>";
    foreach ($fileList as $file) {
        echo "<a href='$file' download>$file</a><br>";
    }
} else {
    echo "No data found in the database.";
}

$conn->close();
?>
