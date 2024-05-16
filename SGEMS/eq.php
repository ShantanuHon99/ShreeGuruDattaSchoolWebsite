<?php
$servername = "localhost";
$username = "shreegur_enquiry";
$password = "SGEMS@12345";
$dbname = "shreegur_queries";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $que = $_POST['que'];

    $stmt = $conn->prepare("INSERT INTO enquiry (Name, Mobile, Question) VALUES (?, ?, ?)");

    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    $stmt->bind_param("sss", $name, $phone, $que);

    $result = $stmt->execute();

    if ($result === false) {
        die("Error: " . $stmt->error);
    } else {
        echo '<script>alert("Thank You for your enquiry! Your query will be answered shortly on WhatsApp.");</script>';
        echo '<script>window.setTimeout(function(){ window.location.href = "index.html"; }, 0);</script>';
        exit();
    }

}

$conn->close();
?>
