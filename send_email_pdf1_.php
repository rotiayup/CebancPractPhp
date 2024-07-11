<?php
include 'header.php';
?>
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
$conn = null;
?>

<div class="top-image">
    <img src="./images/logocebanc_400x400.jpg" alt="Cebanc Logo">
    <img src="./images/world-wide-web.png" alt="WWW">
</div>
<h1>Seleccione Cliente</h1>

<form action="send_email_pdf2.php" method="post">
    <label for="clienteId2">Cliente:</label>
    <select name="clienteId2" id="clienteId2">
        <?php while ($cliente = $clientesResult2->fetch(PDO::FETCH_ASSOC)): ?>
            <option value="<?= $cliente['id'] ?>"><?= $cliente['nombre'] . ' ' . $cliente['apellido'] ?></option>
        <?php endwhile; ?>
    </select>
    <br>
    <button type="submit">Enviar Email con PDF</button>
</form>

<?php include 'footer.php'; ?>