<?php
include 'db.php'; // Assuming your database connection file

try {
    // Get all clientes data
    $clientesSQL = "SELECT id, nombre, apellido, dni, email FROM clientes";
    $clientesResult = $conn->query($clientesSQL);
    $clientesResult2 = $conn->query($clientesSQL);

    // Check if there are any clientes
    if ($clientesResult->rowCount() === 0) {
        echo "No clientes found. Please add clientes to the database.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pedidos de clientes</title>
</head>

<body>
    <div class="top-image">
        <img src="./images/logocebanc_400x400.jpg" alt="Cebanc Logo">
        <img src="./images/world-wide-web.png" alt="WWW">
    </div>
    <h1>Seleccione Cliente</h1>

    <form action="create_pdf_pedido2.php" method="post">
        <label for="clienteId">Cliente:</label>
        <select name="clienteId" id="clienteId">
            <?php while ($cliente = $clientesResult->fetch(PDO::FETCH_ASSOC)) : ?>
                <option value="<?= $cliente['id'] ?>"><?= $cliente['nombre'] . ' ' . $cliente['apellido'] ?></option>
            <?php endwhile; ?>
        </select>
        <br/>
        <br/>
        <button type="submit">Generar Listado PDF</button>
    </form>

</body>

</html>

<?php
$conn = null;
?>