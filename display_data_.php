<?php
include 'header.php';
?>
<?php
include 'db.php';

try {
    // Fetch all clientes
    $clientesSQL = "SELECT * FROM clientes";
    $clientesStmt = $conn->query($clientesSQL);
    $clientes = $clientesStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch all pedidos with cliente information
    $pedidosSQL = "SELECT p.*, c.nombre, c.apellido FROM pedidos p 
                   JOIN clientes c ON p.idcliente = c.id 
                   ORDER BY c.id, p.fecha";
    $pedidosStmt = $conn->query($pedidosSQL);
    $pedidos = $pedidosStmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

$conn = null;
?>

<h1 class="mb-4">Clientes y Pedidos</h1>

<h2>Clientes</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?= htmlspecialchars($cliente['id']) ?></td>
                <td><?= htmlspecialchars($cliente['nombre']) ?></td>
                <td><?= htmlspecialchars($cliente['apellido']) ?></td>
                <td><?= htmlspecialchars($cliente['dni']) ?></td>
                <td><?= htmlspecialchars($cliente['email']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2 class="mt-5">Pedidos</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Num. Pedido</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Descripción</th>
            <th>Importe</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pedidos as $pedido): ?>
            <tr>
                <td><?= htmlspecialchars($pedido['numpedido']) ?></td>
                <td><?= htmlspecialchars($pedido['nombre'] . ' ' . $pedido['apellido']) ?></td>
                <td><?= htmlspecialchars(date('d/m/Y', strtotime($pedido['fecha']))) ?></td>
                <td><?= htmlspecialchars($pedido['descripcion']) ?></td>
                <td><?= htmlspecialchars(number_format($pedido['importe'], 2, ',', '.')) ?> €</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'footer.php'; ?>