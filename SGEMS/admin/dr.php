<?php
// Database connection
$servername = "localhost";
$username = "shreegur_user";
$password = "USER@123321";
$dbname = "shreegur_queries";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM enquiry WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
    }
}

$conn->close();
?>
