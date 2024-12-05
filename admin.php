<?php
require_once 'connect.php';

// Add error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch pets from the database
$sql = "SELECT Pet_ID, Name, ImageURL, Age, Gender, Year_Rescued, Health, Description, Adoption_Status FROM pet";
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pet System</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <nav class="sidebar">
        <ul>
            <li><a href="#dashboard">Dashboard</a></li>
            <li><a href="#">Pets Management</a>
                <ul>
                    <li><a href="admin.php">View All Pets</a></li>
                </ul>
            </li>
            <li><a href="#owners-management">Owners Management</a>
                <ul>
                    <li><a href="#view-all-owners">View All Owners</a></li>
                </ul>
            </li>
            <li><a href="#appointments">Appointments</a>
                <ul>
                    <li><a href="view_all_appointments.php">Appointments</a></li>
                    <li><a href="appointment.php">Schedule New Appointment</a></li>
                </ul>
            </li>
            <li><a href="#medical-records">Medical Records</a>
                <ul>
                    <li><a href="medical.php">View All Records</a></li>
                    <li><a href="addmedicalrecord.php">Add Medical Records</a></li>
                </ul>
            </li>
            <li><a href="#user-management">User Management</a>
                <ul>
                    <li><a href="view-users.php">View All Users</a></li>
                    <li><a href="addnewuser.php">Add a User</a></li>
                </ul>
            </li>               
            </li>
            <li><a href="adminlogin.php">Logout</a></li>
        </ul>
    </nav>
    
    <main>
        <section class="info">
            <h2>Pet Management</h2>
        </section>

        <div class="pets-container" id="petsContainer">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $adoptionStatus = isset($row["Adoption_Status"]) ? $row["Adoption_Status"] : "Not Set";
                    echo "<div class='pet'>";
                    echo "<img src='" . $row["ImageURL"] . "' alt='" . $row["Name"] . "' class='interactive-image' 
                        data-pet-id='" . $row["Pet_ID"] . "' 
                        data-name='" . htmlspecialchars($row["Name"], ENT_QUOTES) . "' 
                        data-age='" . htmlspecialchars($row["Age"], ENT_QUOTES) . "' 
                        data-gender='" . htmlspecialchars($row["Gender"], ENT_QUOTES) . "' 
                        data-year-rescued='" . htmlspecialchars($row["Year_Rescued"], ENT_QUOTES) . "' 
                        data-health='" . htmlspecialchars($row["Health"], ENT_QUOTES) . "' 
                        data-description='" . htmlspecialchars($row["Description"], ENT_QUOTES) . "'
                        data-adoption-status='" . htmlspecialchars($adoptionStatus, ENT_QUOTES) . "'>";
                    echo "<p class='pets-name'>" . $row["Name"] . "</p>";
                    if ($adoptionStatus !== 'Adopted') {
                        echo "<button class='set-adopted-btn' onclick='setAdopted(\"" . $row["Name"] . "\")'>Set Adopted</button>";
                    } else {
                        echo "<p class='adopted-status'>Adopted</p>";
                    }
                    echo "</div>";
                }
            } else {
                echo "No pets found";
            }
            ?>
        </div>
        <button class="add-pet-btn" onclick="openModal()"> + </button>

        <!-- The Modal Structure -->
        <div id="addPetModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Add a New Pet</h2>
                
                <form id="addPetForm">
                    <div class="form-group">
                        <label for="petName">Pet Name:</label>
                        <input type="text" id="petName" name="petName" required>
                    </div>
                
                    <div class="form-group">
                        <label for="petImage">Pet Image URL:</label>
                        <input type="text" id="petImage" name="petImage" required>
                    </div>
                
                    <div class="form-group">
                        <label for="petAge">Pet Age:</label>
                        <input type="text" id="petAge" name="petAge" required>
                    </div>
                    <div class="form-group">
                        <label for="petType">Pet Type:</label>
                        <input type="text" id="petType" name="petType" required>
                    </div>
                    <div class="form-group">
                        <label for="petGender">Pet Gender:</label>
                        <select id="petGender" name="petGender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                
                    <div class="form-group">
                        <label for="petYearRescued">Year Rescued:</label>
                        <input type="number" id="petYearRescued" name="petYearRescued" required>
                    </div>
                
                    <div class="form-group">
                        <label for="petHealth">Health Status:</label>
                        <input type="text" id="petHealth" name="petHealth" required>
                    </div>
                
                    <div class="form-group">
                        <label for="petDescription">Pet Description:</label>
                        <textarea id="petDescription" name="petDescription" required></textarea>
                    </div>
                
                    <div class="modal-actions">
                        <button type="submit" class="add-btn">Add Pet</button>
                    </div>
                </form>
            </div>
        </div>
        
        </div>
     </div>
</div>
    </main>
    <!-- The Popup Structure -->
    <div id="imagePopup" class="popup">
        <div class="popup-card">
            <span class="close" onclick="closePopup()">&times;</span>
            <img class="popup-content" id="popupImage">
            <div class="popup-text">
                <div class="descriptionBox"></div>
                <h1 id="popupTitle">Title</h1>
                <hr class="separator">
                <b>Age: </b><span id="popupAge"></span>
                <hr class="separator">  
                <b>Gender: </b><span id="popupGender"></span>
                <hr class="separator">
                <b>Year Rescued: </b><span id="popupYearRescued"></span>
                <hr class="separator">
                <b>Health: <span id="popupHealth"></span></b>
                <hr class ="separator">
                <b>Description: </b><span id="popupDescription"></span>
                <p id="popupDetails"></p>
                <div>
                    <button type="button" id="popupEditBtn">Edit</button>
                </div>
                
            </div>
        </div>
    </div>
    <div id="editPetModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Pet Information</h2>
        
        <form id="editPetForm" action="update_pet.php" method="POST">
            <input type="hidden" id="editPetId" name="petId">
            <div class="form-group">
                <label for="editPetName">Pet Name:</label>
                <input type="text" id="editPetName" name="editPetName" required>
            </div>
        
            <div class="form-group">
                <label for="editPetImage">Pet Image URL:</label>
                <input type="text" id="editPetImage" name="editPetImage" required>
            </div>
        
            <div class="form-group">
                <label for="editPetAge">Pet Age:</label>
                <input type="text" id="editPetAge" name="editPetAge" required>
            </div>
        
            <div class="form-group">
                <label for="editPetGender">Pet Gender:</label>
                <select id="editPetGender" name="editPetGender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
        
            <div class="form-group">
                <label for="editPetYearRescued">Year Rescued:</label>
                <input type="number" id="editPetYearRescued" name="editPetYearRescued" required>
            </div>
        
            <div class="form-group">
                <label for="editPetHealth">Health Status:</label>
                <input type="text" id="editPetHealth" name="editPetHealth" required>
            </div>
        
            <div class="form-group">
                <label for="editPetDescription">Pet Description:</label>
                <textarea id="editPetDescription" name="editPetDescription" required></textarea>
            </div>
        
            <div class="modal-actions">
                <button type="submit" class="edit-btn">Update Pet</button>
            </div>
        </form>
    </div>
</div>


    <script src="admin.js"></script>
    
</body>
</html>
