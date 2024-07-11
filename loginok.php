<?php
include 'db.php';

session_start();

// Verify the CSRF token
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // CSRF token validation failed, handle the error
        echo "CSRF token validation failed.";
        exit;
    }

    $username = $_POST['username'];
    $passwordx = $_POST['password'];


    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($passwordx, $user['password'])) {
//    if ($user &&  $user['password'] == password_hash($password, PASSWORD_DEFAULT)){
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];

var_dump($_SESSION['username']. ' - ' . $_SESSION['role']. ' - '.$_SESSION['csrf_token'].'|');
//die();
        header("Location: pag_princ.php");
    } else {
        echo "Invalid username or password.";
    }
}
?>

<h1 class="mt-5">Menu principal</h1>