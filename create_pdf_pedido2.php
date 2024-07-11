<?php
include 'db.php'; // Assuming your database connection file
require 'vendor/autoload.php';
require 'funciones.php';  // Include the funciones.php file

// Handle form submission
if (isset($_POST['clienteId'])) {
    $clienteId = $_POST['clienteId'];
    $pdfName = f_crear_pdf($conn, $clienteId,0);

    if ($pdfName) {
        echo "PDF generated successfully. Filename: " . $pdfName;
        header("Location: pag_princ.php"); // Redirect to menu.php after success

        exit; // Stop script execution after redirect
    } else {
        echo "Error generating PDF.";
    }
} else {
    echo "No client selected.";
}
