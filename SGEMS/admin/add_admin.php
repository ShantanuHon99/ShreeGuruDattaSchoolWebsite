<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "shreegur_user";
    $password = "USER@123321";
    $dbname = "shreegur_queries";

    $con = new mysqli($servername, $username, $password, $dbname);

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $superadmin_name = 'SGEMS_admin'; 
    $sql_fetch_password = "SELECT password FROM admin WHERE name = '$superadmin_name'";
    $result = $con->query($sql_fetch_password);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $superadmin_password = $row["password"];
    } else {
        echo "SuperAdmin not found.";
        $con->close();
        exit;
    }

    $admin_password_from_form = $_POST["admin_password"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql_check_username = "SELECT * FROM admin WHERE name = '$username'";
    $result_username = $con->query($sql_check_username);

    if ($result_username->num_rows > 0) {
        echo "<script>alert('Username already exists. Please choose a different username.');</script>";
    } else {
        if ($admin_password_from_form !== $superadmin_password) {
            echo "<script>alert('Invalid admin password.');</script>";
            header("Location: login.php");
            $con->close();
            exit;
        }

        $sql_insert_subadmin = "INSERT INTO admin (name, password) VALUES (?, ?)";
        $stmt = $con->prepare($sql_insert_subadmin);
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Sub-Admin created successfully...');</script>";
            echo "<script>window.location.href = 'login.php';</script>"; 
            exit;
        } else {
            echo "<script>alert('Error....');</script>";
        }
    }

    $con->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <title>Admin Panel</title>

    <style>

        .card1 {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
            width: 300px;
          justify-content: center;
            text-align: center;
            height:auto;
        }
         @media only screen and (max-width: 600px) {
  .card1 {
    height: auto;
  }
}

        h2 {
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        input[type="password"] {
            font-family: 'Arial';
        }

        .submit-btn {
            background-color: #ff0000;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
        }

        .container1 {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f1f1f1;
        }

        .content {
            text-align: center;
        }

        .password-input-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-input-container i {
            position: absolute;
            right: 10px;
            cursor: pointer;
        }
       
    </style>
</head>
<body>
    
    <div class="container1">
        <div class="content">
            <div class="card1">
                <h2><span style="color:red; font-weight:600;">Shree Guru Datta English Medium School</span></h2>
                <h2>Create Sub-Admin</h2>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                        <button type="button" id="togglePassword">Show</button>
                    </div>
                    
                     <div class="form-group">
                        <label for="password">Admin Password</label>
                        <input type="password" id="admin_password" name="admin_password" required>
                        <button type="button" id="toggleAdminPassword">Show</button>
                    </div>
                    </div>
                    
                    <button type="submit" class="submit-btn" id = 'btn_submit'>Submit</button>
                </form>
            </div>
        </div>
    </div>






            
       <script>
        // Function to toggle password visibility
        function togglePasswordVisibility(inputId, toggleId) {
            var passwordInput = document.getElementById(inputId);
            var toggleButton = document.getElementById(toggleId);

            // Toggle the password input type between "password" and "text"
            passwordInput.type = passwordInput.type === "password" ? "text" : "password";
            // Toggle the button text between "Show" and "Hide"
            toggleButton.textContent = passwordInput.type === "password" ? "Show " : "Hide " ;
        }

        // Add event listener for password toggle button
        document.getElementById('togglePassword').addEventListener('click', function () {
            togglePasswordVisibility('password', 'togglePassword');
        });

        // Add event listener for admin password toggle button
        document.getElementById('toggleAdminPassword').addEventListener('click', function () {
            togglePasswordVisibility('admin_password', 'toggleAdminPassword');
        });
    </script>
            

        
</body>
</html>