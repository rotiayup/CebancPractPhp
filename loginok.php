<?php
/*
include 'db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $passwordx = $_POST['password'];

    var_dump($username);
    var_dump($passwordx);
    //die();

//    include 'db.php';

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    echo'<br/>--0--';
    var_dump($user);
    echo'<br/>--1--';
    if ($user && password_verify($passwordx, $user['password'])) {
//    if ($user &&  $user['password'] == password_hash($password, PASSWORD_DEFAULT)){
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];
        header("Location: pag_princ.php");
    } else {
        echo "Invalid username or password.";
    }
}
?>

<h1 class="mt-5">Menu principal</h1>

<?php
*/
?>

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

    var_dump($username);
    var_dump($passwordx);
    //die();

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    echo'<br/>--0--';
    var_dump($user);
    echo'<br/>--1--';
    if ($user && password_verify($passwordx, $user['password'])) {
//    if ($user &&  $user['password'] == password_hash($password, PASSWORD_DEFAULT)){
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];
        header("Location: pag_princ.php");
    } else {
        echo "Invalid username or password.";
    }
}
?>

<h1 class="mt-5">Menu principal</h1>