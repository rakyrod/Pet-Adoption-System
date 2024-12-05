<?php
require_once 'connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Prepare a statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin WHERE UserName = ? AND position = 'Manager'");
    $stmt->bind_param("s", $_POST["username"]);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Directly compare the plain text password (note: not secure)
        if (isset($user["Password"]) && $_POST["password"] === $user["Password"]) {
            
            session_start();
            session_regenerate_id(); // Avoid session fixation attacks
            
            $_SESSION["admin_id"] = $user["id"]; // Use a different session key for admin
            
            header("Location: admin.php"); // Redirect to admin dashboard
            exit;
        } else {
            echo "<script>alert('Incorrect password.');</script>";
        }
    } else {
        echo "<script>alert('Admin user not found.');</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Sign-up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: whitesmoke;
            background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center center;
            width: 100%;
            height: 100vh; 
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            width: 100%;
            max-width: 390px;
            padding: 16px;
            background-color: #fff;
            box-shadow: 0px 0px 10px 0px #00000020;
            border-radius: 8px;
            z-index: 1; 
            position: relative;
        }

        h2 {
            text-align: center;
        }

        input[type="text"], input[type="password"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        a {
            display: block;
            margin-top: 10px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .form-container {
                padding: 15px;
            }

            input[type="text"], input[type="password"], input[type="email"], input[type="submit"] {
                padding: 12px;
            }
        }
    </style>
    <script>
        function handleLogin(event) {
            event.preventDefault(); 

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            const user = JSON.parse(localStorage.getItem(username));

            if (user && user.password === password) {
                localStorage.setItem('loggedIn', true);
                localStorage.setItem('user', JSON.stringify(user));

                alert("Login successful!");
                window.location.href = "admin.html"; 
            } else {
                alert("User not found or incorrect password. Please sign up.");
                window.location.href = "sign.html"; 
            }
        }
    </script>
</head>
<body>

<div class="form-container">
    <h2>Admin Login</h2>
    <form method = "post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Login">
    </form>
    <a href="sign.html">Create account.</a> 
</div>

</div>
</body>
</html>
