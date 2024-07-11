// logout.php
<?php
/*
session_start();
session_unset();
session_destroy();
header("Location: index.php");
*/
?>

<?php
session_start();

var_dump($_GET['csrf_token'] .' - '. $_SESSION['csrf_token']);
//die();

// Verify the CSRF token
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET['csrf_token']) || $_GET['csrf_token'] !== $_SESSION['csrf_token']) {
        // CSRF token validation failed, handle the error
        echo "CSRF token validation failed.";
        exit;
    }

    // Logout the user
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
