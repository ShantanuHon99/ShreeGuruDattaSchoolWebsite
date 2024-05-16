<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}
if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
$servername = "localhost";
$username = "shreegur_user";
$password = "USER@123321";
$dbname = "shreegur_queries";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, Name, Mobile, Question FROM enquiry"; 
$result = $conn->query($sql);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Enquiry Dashboard</title>
       <style>
       .logout-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            background-color: red;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
        }
        body {
    margin: 0;
    background-color: rgb(255, 235, 211);
    font-family: Arial, sans-serif;
}

.dashboard h1 {
    display: flex;
    justify-content: center;
    padding: 20px;
    border-radius: 20px 0 20px 0;
    margin: 20px auto;
    background-color: rgb(219, 100, 31);
    color: rgb(255, 255, 255);
    font-size: 2.5rem;
    width: fit-content;
}

.container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 20px;
}

.card {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 10px;
    padding: 20px;
    width: calc(33.33% - 40px);
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.card p {
    font-weight: 600;
    color: rgb(0, 0, 0);
    margin: 10px 0;
}

.card a {
    border-radius: 20px;
    background-color: green;
    color: white;
    display: block;
    margin: 20px auto 10px;
    padding: 10px;
    text-align: center;
    text-decoration: none;
    width: 150px;
}

.card button {
    background-color: red;
    border: none;
    border-radius: 20px;
    color: white;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 600;
    margin: 10px auto;
    padding: 10px;
    text-align: center;
    width: 50%;
}
@media only screen and (max-width: 790px) {
    .card {
        width: calc(100% - 20px);
    }
    .container {
    flex-direction:column;
}
}


    </style>
    </head>
    <body>

    <div class="dashboard">
        <h1>Enquiry Dashboard</h1>
    </div>
    <div class="container">
    <?php
    while($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $name = $row["Name"]; 
        $mobile_number = $row["Mobile"]; 
        $question = $row["Question"]; 
        ?>
        <div class="card">
        <form method="POST" action="dr.php">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div>
                    <p>Name: <?php echo $name; ?></p>
                    <p>Mobile Number: <?php echo $mobile_number; ?></p>
                    <p>Question: <span style="color: red"><?php echo $question; ?></span></p> 
                    <a href="https://wa.me/<?php echo $mobile_number; ?>?text=Hello%20<?php echo urlencode($name); ?>%2C%20You%20sent%20an%20enquiry%20message%20to%20us%20asking%3A%20<?php echo urlencode($question); ?>" target="_blank" style="font-size:.9rem;">Reply on WhatsApp</a>
                    <button type="submit">Delete</button>
                </div>
        </form>
        </div>
        <?php
    }
    ?>
    </div>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <button type="submit" class="logout-btn" name="logout">Logout</button>
</form>
    </body>
    </html>
    <?php

$conn->close();
?>
