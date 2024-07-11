<?php
/*
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Menu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Menu</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="create_tables_.php">Crear tablas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="display_data_.php">Mostrar datos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="create_pdf_pedido1_.php">Crear PDF Pedido</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="send_email_pdf1_.php">Enviar email con PDF</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">