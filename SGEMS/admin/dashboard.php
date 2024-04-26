<?php
// Database connection
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "database_name";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, mobile_number FROM records";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $name = $row["name"];
        $mobile_number = $row["mobile_number"];
    }
} else {
    echo "0 results";
    
}
$conn->close();


?>

<!DOCTYPE html>
<html>
<head>
    <title>Enquiry Dashboard</title>
</head>
<body>

        <div>
            <p>Name: <?php echo $name; ?></p>
            <p>Mobile Number: <?php echo $mobile_number; ?></p>
            <a href="https://wa.me/<?php echo $mobile_number; ?>" target="_blank">Send WhatsApp Message</a>
            <a href="https://wa.me/9767702426?text=Hello%20<?php echo $name; ?>%2C%20You%20sent%20an%20enquiry%20message%20to%20us%20asking%3A%20<?php echo $question; ?>" target="_blank">Send WhatsApp Message</a>

        </div>

</body>
</html>

