<?php
include 'db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];
        header("Location: menu.php");
    } else {
        echo "Invalid username or password.";
    }
}
?>

<?php
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
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
                    <a class="nav-link" href="create_tables.php">Crear tablas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="display_data.php">Mostrar datos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="create_pdf_pedido1.php">Crear PDF Pedido</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="send_email_pdf1.php">Enviar email con PDF</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <!--<a href="logout.php" class="btn btn-danger">Logout</a>-->
                    <a href="logout.php?csrf_token=<?php echo $_SESSION['csrf_token']; ?>" class="btn btn-danger">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1 class="mt-5">Menu principal</h1>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>