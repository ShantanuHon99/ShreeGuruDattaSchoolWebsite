<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, Name, Mobile, Question FROM enquiry"; // Modified the column names in the SQL query
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $name = $row["Name"]; // Updated column name
        $mobile_number = $row["Mobile"]; // Updated column name
        $question = $row["Question"]; // Added fetching the Question column
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
                <p>Question: <?php echo $question; ?></p> <!-- Added displaying the question -->
                <a href="https://wa.me/<?php echo $mobile_number; ?>?text=Hello%20<?php echo urlencode($name); ?>%2C%20You%20sent%20an%20enquiry%20message%20to%20us%20asking%3A%20<?php echo urlencode($question); ?>" target="_blank">Send WhatsApp Message</a>
        </div>
        </body>
        </html>
        <?php
    }
} else {
    echo "0 results";
}
$conn->close();
?>
