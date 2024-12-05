<?php
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $user_id = $conn->real_escape_string($_POST['user_id']); // Assuming the username field is named "username"
    $pet_id = $conn->real_escape_string($_POST['pet_id']); // Assuming the pet name field is named "pet-name"
    $appointment_date = $conn->real_escape_string($_POST['appointment_date']);
    $appointment_time = $conn->real_escape_string($_POST['appointment_time']);
    // Validate and sanitize input
    $errors = [];
    if (empty($user_id)) {
        $errors[] = "Owner ID is required.";
    }
    if (empty($pet_id)) {
        $errors[] = "Pet ID is required.";
    }
    if (empty($appointment_date)) {
        $errors[] = "Appointment Date is required.";
    }
    if (empty($appointment_time)) {
        $errors[] = "Appointment Time is required.";
    }
    if (!empty($errors)) {
        echo implode("<br>", $errors);
        exit;
    }
    
    // Check if appointment already exists
    $sql = "SELECT * FROM appointment WHERE user_id = '$user_id' AND pet_id = '$pet_id' AND date = '$appointment_date' AND time = '$appointment_time'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "Appointment already exists for this owner and pet on this date and time.";
        exit;
    }
    
    // Insert appointment into the database
    $sql = "INSERT INTO appointment (user_id, pet_id, date, time) VALUES ('$user_id', '$pet_id', '$appointment_date', '$appointment_time')";
    if ($conn->query($sql) === TRUE) {
        echo "New appointment scheduled successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale =1.0">
    <title>Schedule New Appointment</title>
    <link rel="stylesheet" href="appointment.css">
</head>
<body>
    <nav class="sidebar">
    <ul>
            <li><a href="#dashboard">Dashboard</a></li>
            <li><a href="admin.php">Pets Management</a>
                <ul>
                    <li><a href="admin.php">View All Pets</a></li>
                </ul>
            </li>
            <li><a href="#owners-management">Owners Management</a>
                <ul>
                    <li><a href="#view-all-owners">View All Owners</a></li>                   
                </ul>
            </li>
            <li><a href="#appointment">appointment</a>
                <ul>
                    <li><a href="view_all_appointments.php">View All appointment</a></li>
                    <li><a href="appointment.php">Schedule New Appointment</a></li>
                </ul>
            </li>
            <li><a href="#medical-records">Medical Records</a>
                <ul>
                    <li><a href="medical.php">View All Records</a></li>
                </ul>
            </li>
            <li><a href="#user-management">User Management</a>
                <ul>
                    <li><a href="view-users.php">View All Users</a></li>
                    <li><a href="adduser.php">Add New User</a></li>
                </ul>
            </li>
            <li><a href="adminlogin.php">Logout</a></li>
        </ul>
    </nav>

    <main>
        <section class="info">
            <h2>Schedule New Appointment</h2>
        </section>

        <section class="Appointment-Schedule-form">
            <form action="appointment.php" method="post">
                <fieldset>
                    <legend>Appointment Schedule</legend>
                    <label for="name">User ID</label>
                    <input type="text" id="user_id" name="user_id" placeholder="Enter the User ID">
                    <label for="name">Pet ID</label>
                    <input type="text" id="pet_id" name="pet_id" placeholder="Enter Pet ID">
                    <label for="name">Date</label>
                    <input type="text" id="date" name="appointment_date" placeholder="YYYY/MM/DD">
                    <label for="name">Time</label>
                    <input type="text" id="time" name="appointment_time" placeholder="11:00 AM">
                </fieldset>
                <div class="form-buttons">
                    <button type="submit">Submit</button>
                    <button type="reset">Clear Form</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>