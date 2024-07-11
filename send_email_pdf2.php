<?php
include 'db.php'; // Assuming your database connection file
require 'vendor/autoload.php';
//include 'create_pdf_pedido2.php';
//include 'send_email2.php';
require 'funciones.php';  // Include the funciones.php file

use Dompdf\Dompdf;

// Handle form submission
if (isset($_POST['clienteId2'])) {
    $clienteId2 = $_POST['clienteId2'];

    $stmt = $conn->prepare("SELECT nombre, apellido, email FROM clientes WHERE id = :clienteId");
    $stmt->bindParam(':clienteId', $clienteId2, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $nombre = $result['nombre'];
    $apellido = $result['apellido'];
    $email = $result['email'];


    $pdfName = f_crear_pdf($conn, $clienteId2,1);
    $emailpdfok = enviar_email_pdf($email, "Pedidos de " . $nombre . " " . $apellido, "Listado de pedidos del cliente " . $nombre . " " . $apellido, $pdfName);

    
    if ($emailpdfok) {
        echo "Email enviado correctamente";
        header("Location: pag_princ.php"); // Redirect to menu.php after success
        //header("Location: menu.php"); // Redirect to menu.php after success
        //exit; // Stop script execution after redirect

    } else {
        echo "Error enviando email";
    }
} else {
    echo "No se ha seleccionado cliente";
}

$conn = null;
