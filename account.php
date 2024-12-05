<?php
session_start();
require_once 'connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === null) {
    // User is not logged in, redirect to login page
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data from the database
$stmt = $conn->prepare("SELECT * FROM user WHERE User_ID = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    // User not found in database, log out and redirect
    session_destroy();
    header("Location: index.php");
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACCOUNT | FUR-EVER BAHAY</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="account.css">
</head>
<body>
    <nav>
        <div class="logo"><i class="fa-solid fa-house-chimney"></i> FUR-EVER BAHAY</div>
        <div class="nav-items">
            <a href="homepage.php">HOME</a> 
            <a href="about.php">ABOUT US</a> 
            <a href="adopt.php">ADOPT</a> 
            <a href="donation.php">DONATION</a> 
            <a href="account.php">ACCOUNT</a>
        </div>
    </nav>

    <section class="account-info">
        <h1>Account Management</h1>
        <div class="profile-section">
            <h2>Your Profile</h2>
            <div class="profile-info">
                <img src="images/profile-pic-placeholder.png" alt="Profile Picture" class="profile-pic">
                <div class="profile-details">
                    <p><strong>First Name:</strong> <span id="first-name"><?php echo htmlspecialchars($user['FirstName'] ?? ''); ?></span></p>
                    <p><strong>Last Name:</strong> <span id="last-name"><?php echo htmlspecialchars($user['LastName'] ?? ''); ?></span></p>
                    <p><strong>Email:</strong> <span id="email"><?php echo htmlspecialchars($user['Email'] ?? ''); ?></span></p>
                    <p><strong>Phone Number:</strong> <span id="phone"><?php echo htmlspecialchars($user['PhoneNumber'] ?? ''); ?></span></p>
                    <p><strong>Work:</strong> <span id="work"><?php echo htmlspecialchars($user['Work'] ?? ''); ?></span></p>
                </div>
            </div>
        </div>
        <button class="edit-profile-btn" id="edit-profile-btn">Edit Profile</button>
        <button class="sign-out-btn" id="sign-out-btn">Sign Out</button>

        <div class="edit-form" id="edit-form" style="display: none;">
            <h2>Edit Profile</h2>
            <form id="profile-form">
                <label for="edit-first-name">First Name:</label>
                <input type="text" id="edit-first-name" value="<?php echo htmlspecialchars($user['FirstName'] ?? ''); ?>">
                <br>
                <label for="edit-last-name">Last Name:</label>
                <input type="text" id="edit-last-name" value="<?php echo htmlspecialchars($user['LastName'] ?? ''); ?>">
                <br>
                <label for="edit-email">Email:</label>
                <input type="email" id="edit-email" value="<?php echo htmlspecialchars($user['Email'] ?? ''); ?>">
                <br>
                <label for="edit-phone">Phone Number:</label>
                <input type="tel" id="edit-phone" value="<?php echo htmlspecialchars($user['Phone'] ?? ''); ?>">
                <br>
                <label for="edit-work">Work:</label>
                <input type="text" id="edit-work" value="<?php echo htmlspecialchars($user['Work'] ?? ''); ?>">
                <br>
                <button type="submit" class="save-btn">Save Changes</button>
                <button type="button" class="cancel-btn" id="cancel-btn">Cancel</button>
            </form>
        </div>
    </section>

    <<footer>
    <div class="footer-container">
        <div class="logo-footer"><i class="fa-solid fa-house-chimney"></i> FUR-EVER BAHAY</div>
        <div class="row">
            <a href="https://web.facebook.com/pawsphilippines" target="_blank"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://www.instagram.com" target="_blank"><i class="fa-brands fa-instagram"></i></a>
        </div>
        <div class="footer-content">
            <div class="footer-nav">
                <h3>ABOUT US</h3>
                <p>Our main job is to teach people about animal welfare, how to care for animals, and manage animal control issues. We also provide information on various animal-related topics.</p>
                <p>FUR-EVER BAHAY is dedicated to fighting againsft animal cruelty and pet neglect. We oppose activities such as dogfights, horse fights, and using wild animals for entertainment.</p>
            </div>
            <div class="footer-nav">
                <h3>HOW TO REACH US?</h3>
                <p>Address: University of Mindanao, Matina Pangi Rd, Davao City, Davao del Sur</p>
                <p>Contact Number: 09693628992</p>
                <p>Email: petadoptionsystem@gmail.com</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024; Designed by: Pet Adoption System</p>
        </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit Profile button functionality
        document.getElementById('edit-profile-btn').addEventListener('click', function() {
            document.getElementById('edit-form').style.display = 'block';
        });

        // Cancel button functionality
        document.getElementById('cancel-btn').addEventListener('click', function() {
            document.getElementById('edit-form').style.display = 'none';
        });

        // Profile form submission
        document.getElementById('profile-form').addEventListener('submit', function(event) {
            event.preventDefault();
            // Add AJAX call to update user data
            // Update displayed profile information on success
        });

        // Sign out functionality
        document.getElementById('sign-out-btn').addEventListener('click', function() {
            fetch('logout.php')
                .then(() => {
                    window.location.href = 'index.php';
                });
        });
    });
    </script>
</body>
</html>