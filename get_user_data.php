<?php
session_start();
if (isset($_SESSION['user_id'])) {
    // Fetch user data from database
    // This is a placeholder, replace with actual database query
    $user = [
        'firstName' => 'John',
        'lastName' => 'Doe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'work' => 'Developer'
    ];
    echo json_encode($user);
} else {
    echo json_encode(null);
}
?>