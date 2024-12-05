<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "admin";
$password = "123";
$dbname = "adoption_center";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $work = $conn->real_escape_string($_POST['work']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirm_password = $conn->real_escape_string($_POST['confirm_password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // Password confirmation check
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }

    // Hash the password
    

    // Insert data into the database
    $sql = "INSERT INTO user (FirstName, LastName, Email, PhoneNumber, Work, UserName, Password) 
            VALUES ('$first_name', '$last_name', '$email', '$phone', '$work', '$username', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header('Location: index.php'); // Redirect to login page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
