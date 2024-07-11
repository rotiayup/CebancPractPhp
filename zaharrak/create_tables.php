<?php
include 'db.php';
try {
  // Drop tables if they exist (optional, for clean execution)
  $dropPedidosSQL = "DROP TABLE IF EXISTS pedidos";
  $conn->exec($dropPedidosSQL);
  echo "Table pedidos dropped successfully (if it existed).<br>";

  $dropClientesSQL = "DROP TABLE IF EXISTS clientes";
  $conn->exec($dropClientesSQL);
  echo "Table clientes dropped successfully (if it existed).<br>";

  // Create clientes table
  $createClientesSQL = "
    CREATE TABLE clientes (
      id INT AUTO_INCREMENT PRIMARY KEY,
      nombre VARCHAR(50) NOT NULL,
      apellido VARCHAR(50) NOT NULL,
      dni VARCHAR(11) NOT NULL UNIQUE,
      email VARCHAR(100) NOT NULL UNIQUE
    )
  ";
  $conn->exec($createClientesSQL);
  echo "Table clientes created successfully.<br>";

  // Create pedidos table (linking to clientes.id)
  $createPedidosSQL = "
    CREATE TABLE pedidos (
      numpedido INT AUTO_INCREMENT PRIMARY KEY,
      idcliente INT NOT NULL,
      fecha DATE NOT NULL,
      descripcion VARCHAR(255) NOT NULL,
      importe DECIMAL(10,2) NOT NULL,
      FOREIGN KEY (idcliente) REFERENCES clientes(id)
    )
  ";
  $conn->exec($createPedidosSQL);
  echo "Table pedidos created successfully.<br>";

////////////////////////////////////////////////////////////////  

  // Insert data into clientes table
  $insertClientesSQL = "
    INSERT INTO clientes (nombre, apellido, dni, email)
    VALUES (:nombre, :apellido, :dni, :email)
  ";
  $clientesData = [
    [":nombre" => "Miren", ":apellido" => "Alberdi", ":dni" => "11111111A", ":email" => "puyaitor@gmail.com"],
    [":nombre" => "Andoni", ":apellido" => "Prieto", ":dni" => "22222222A", ":email" => "carmenberasarte@gmail.com"],
  ];

  $stmt = $conn->prepare($insertClientesSQL);
  foreach ($clientesData as $data) {
    $stmt->execute($data);
  }
  echo "Data inserted into clientes table successfully.<br>";


  // Retrieve id of Miren from clientes table
  $getMirenIdSQL = "SELECT id FROM clientes WHERE nombre = 'Miren'";
  $mirenResult = $conn->query($getMirenIdSQL);
  $mirenId = $mirenResult->fetch(PDO::FETCH_ASSOC)['id']; // Assuming single row for Miren

  // Insert data into pedidos table
  $insertPedidosSQL = "
    INSERT INTO pedidos (numpedido, idcliente, fecha, descripcion, importe)
    VALUES (:numpedido, :idcliente, STR_TO_DATE(:fecha, '%d/%m/%Y'), :descripcion, :importe)
  ";

  $pedidosData = [
    [":numpedido" => 101, ":idcliente" => $mirenId, ":fecha" => "01/01/2024", ":descripcion" => "Descripción pedido 101", ":importe" => 100],
    [":numpedido" => 102, ":idcliente" => $mirenId, ":fecha" => "11/02/2024", ":descripcion" => "Descripción pedido 102", ":importe" => 145.50],
    [":numpedido" => 103, ":idcliente" => $mirenId, ":fecha" => "17/03/2024", ":descripcion" => "Descripción pedido 103", ":importe" => 1200]];
 
    $stmt = $conn->prepare($insertPedidosSQL);
    foreach ($pedidosData as $data) {
      $stmt->execute($data);
    }
    echo "Data inserted into pedidos table successfully.<br>";


  // Retrieve id of Andoni from clientes table
  $getMirenIdSQL = "SELECT id FROM clientes WHERE nombre = 'Andoni'";
  $mirenResult = $conn->query($getMirenIdSQL);
  $mirenId = $mirenResult->fetch(PDO::FETCH_ASSOC)['id']; // Assuming single row for Miren

  // Insert data into pedidos table
  $insertPedidosSQL = "
    INSERT INTO pedidos (numpedido, idcliente, fecha, descripcion, importe)
    VALUES (:numpedido, :idcliente, STR_TO_DATE(:fecha, '%d/%m/%Y'), :descripcion, :importe)
  ";

  $pedidosData = [
    [":numpedido" => 104, ":idcliente" => $mirenId, ":fecha" => "22/01/2024", ":descripcion" => "Descripción pedido 104", ":importe" => 1100.45],
    [":numpedido" => 105, ":idcliente" => $mirenId, ":fecha" => "13/02/2024", ":descripcion" => "Descripción pedido 105", ":importe" => 36],
    [":numpedido" => 106, ":idcliente" => $mirenId, ":fecha" => "04/05/2024", ":descripcion" => "Descripción pedido 106", ":importe" => 420.60]];
 
    $stmt = $conn->prepare($insertPedidosSQL);
    foreach ($pedidosData as $data) {
      $stmt->execute($data);
    }
    echo "Data inserted into pedidos table successfully.<br>";

}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
