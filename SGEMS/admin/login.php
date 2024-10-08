<?php
session_start(); 

if (isset($_POST["submit"])) {
    $servername = "localhost";
    $username = "shreegur_user";
    $password = "USER@123321";
    $dbname = "shreegur_queries";

    $con = new mysqli($servername, $username, $password, $dbname);

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Use prepared statements to prevent SQL injection
    $stmt = $con->prepare("SELECT * FROM admin WHERE name=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION["loggedin"] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $loginError = "Invalid username or password.";
    }

    $stmt->close();
    $con->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>.content {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
            width: 300px;
          justify-content: center;
            text-align: center;
            height:25vw;
        }
        @media only screen and (max-width: 600px) {
  .content {
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
        }</style>
</head>
<body>
    <div class="container1">
        <div class="content">
            <div class="card1">
                <h2>Shree Guru Datta English Medium School <br><br><span style="color:red; font-weight:600;">Admin Login</span></h2>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <div class="password-input-container">
                            <input type="password" id="password" name="password" required>
                            <button type="button" id="togglePassword">Show</button>
                        </div>
                    </div>
                    <button type="submit" class="submit-btn" name="submit">Submit</button>
                    
                </form>
                <a href="add_admin.php" style="margin-top:20px;">Register Admin?</a>
                <?php
                // Display login error message if set
                if (isset($loginError)) {
                    echo "<p>$loginError</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        // Function to toggle password visibility
        function togglePasswordVisibility(inputId, toggleId) {
            var passwordInput = document.getElementById(inputId);
            var toggleIcon = document.getElementById(toggleId);

            // Toggle the password input type between "password" and "text"
            passwordInput.type = passwordInput.type === "password" ? "text" : "password";
            // Toggle the button text between "Show Password" and "Hide Password"
            toggleIcon.textContent = passwordInput.type === "password" ? "Show" : "Hide";
        }

        // Add event listener for password toggle
        document.getElementById('togglePassword').addEventListener('click', function () {
            togglePasswordVisibility('password', 'togglePassword');
        });
    </script>
</body>
</html>
