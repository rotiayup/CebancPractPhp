<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
/*
if (!function_exists('getConfig')) {
    function getConfig($filename)
    {
        if (!file_exists($filename)) {
            throw new Exception("Configuration file not found.");
        }
        return parse_ini_file($filename, true);
    }
}
*/

if (!function_exists('getConfig')) {
    function getConfig() {
      // Access environment variables directly
      $config = [
        'mail' => [
          'host' => $_ENV['EMAIL_HOST'],
          'from_email' => $_ENV['EMAIL_FROM_EMAIL'],
          'from_name' => $_ENV['EMAIL_FROM_NAME'],
          'password' => $_ENV['EMAIL_PASSWORD'],
          'from_email2' => $_ENV['EMAIL_FROM_EMAIL2'],
          'from_name2' => $_ENV['EMAIL_FROM_NAME2'],
          'port' => $_ENV['EMAIL_PORT'],
        ],
      ];
      return $config;
    }
  }
  
function enviar_email_pdf($to_email, $subject, $message, $pdfName)
{
    //$config = getConfig('config.ini');
    $config = getConfig();
    $mail_config = $config['mail'];

    $from_email = $mail_config['from_email'];
    $from_name = $mail_config['from_name'];
    $from_email2 = $mail_config['from_email2'];
    $from_name2 = $mail_config['from_name2'];

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = $mail_config['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $from_email;
        $mail->Password = $mail_config['password'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $mail_config['port'];

        $mail->setFrom($from_email2, $from_name2);
        $mail->addAddress($to_email);

        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Attach the PDF
        if ($pdfName != "") {
            $mail->addAttachment('pdf/' . $pdfName, $pdfName);
        }

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

function f_crear_pdf($conn, $clienteId, $tipo)
{
    global $conn;

    try {
        // Get cliente details
        $getClienteSQL = "SELECT * FROM clientes WHERE id = :clienteId";
        $stmt = $conn->prepare($getClienteSQL);
        $stmt->bindParam(':clienteId', $clienteId, PDO::PARAM_INT);
        $stmt->execute();
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get pedidos for the selected cliente
        $pedidosSQL = "SELECT numpedido, fecha, descripcion, importe FROM pedidos WHERE idcliente = :clienteId";
        $stmt = $conn->prepare($pedidosSQL);
        $stmt->bindParam(':clienteId', $clienteId, PDO::PARAM_INT);
        $stmt->execute();
        $pedidosData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Calculate total importe
        $totalImporte = array_sum(array_column($pedidosData, 'importe'));
        $formattedTotal = number_format($totalImporte, 2, ',', '.');

        // DOMPDF setup
        $dompdf = new Dompdf();

        $path = './images/logocebanc_400x400.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64a = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $path = './images/world-wide-web.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64b = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Cliente Factura</title>
            <style>
            body {
                font-family: Arial, sans-serif;
            }
                /* New styles for column groups */
                .header {
                display: flex;  /* Use flexbox for layout */
                justify-content: space-between;  /* Align items at opposite ends */
                padding: 10px;  /* Optional: Add some padding for visual separation */

                }

                .logo-info {
                display: flex;  /* Make logo-info a flex container */
                align-items: center;  /* Align content vertically */
                }

                .cliente-info {
                text-align: left;  /* Align content left within the right column */
                }
                table {
                border-collapse: collapse;
                width: 100%;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
            }
            th {
                text-align: left;
            }
            /* Right align "importe" column */
            .importe {
                text-align: right;
            }
            .footer-total table {
            border: 1px solid #ddd; /* Add an external border to the table */
            width: 100%; /* Expand table to fill available space (optional) */
            }
            .footer-total td {
            border: none; /* Remove cell borders */
            padding: 5px; /* Add some padding for spacing (optional) */
            }
            </style>
        </head>
        <body>
        <header class="header">
        <table>
            <tr>
            <td width="60%">
                <div class="logo-info">
                    <img src="' . $base64a . '" width="50" height="50"  alt="Logo Cebanc"/>
                    <img src="' . $base64b . '" width="50" height="50"  alt="Logo WWW"/>
                    <h1>Cebanc</h1>
                </div>
            </td>
            <td>
                <div class="cliente-info">
                    <p>' . $cliente['nombre'] . ' ' . $cliente['apellido'] . '</p>
                    <p>DNI: ' . $cliente['dni'] . '</p>
                    <p>Email: ' . $cliente['email'] . '</p>
                </div>
            </td>
            </tr>
        </table>

        </header>
            <br>
            <table>
            <thead>
                <tr>
                <th>Pedido</th>
                <th>Fecha</th>
                <th>Descripción</th>
                <th class="importe">Importe</th>
                </tr>
            </thead>
            <tbody>';

        // Add pedidos data to table body
        foreach ($pedidosData as $pedido) {
            $html .= '<tr>
                <td>' . $pedido['numpedido'] . '</td>
                <td>' . date('d/m/Y', strtotime($pedido['fecha'])) . '</td>
                <td>' . $pedido['descripcion'] . '</td>
                <td class="importe">' . number_format($pedido['importe'], 2, ',', '.') . ' €</td>
                </tr>';
        }

        $html .= '
            </tbody>
            </table>
            <br>
            <footer>
            <div class="footer-total">
                <table>
                <tr>
                    <td>Total:</td>
                    <td class="importe">' . $formattedTotal . ' €</td>
                </tr>
                </table>
            </div>
            </footer>
        </body>
        </html>
        ';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Generate PDF filename
        $nombrearchivo = 'pedidos_' . $cliente['nombre'] . '_' . $cliente['apellido'] . '_' . time() . '.pdf';

        // Save the PDF on the server
        $pdfOutput = $dompdf->output();




        if ($tipo == 0) {
            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename="' . $nombrearchivo . '"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . strlen($pdfOutput));

            echo $pdfOutput;
            exit();
        }


        file_put_contents('pdf/' . $nombrearchivo, $pdfOutput);
        return $nombrearchivo;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

?>