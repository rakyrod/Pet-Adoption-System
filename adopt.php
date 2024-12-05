<?php
require_once 'connect2.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADOPT | FUR-EVER BAHAY</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="adopt.css">
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

    <section class="info-pets">
        <h2>OUR LOVELY PETS</h2>
        <p>All of our pets are neutered and healthy. They are excited to make you happy!</p>
    </section>

    <footer>
        <div class="pets-container">
            <?php
            // Query to get available pets
            $sql = "SELECT Name, ImageURL, Age, Gender, Year_Rescued, Health, Description FROM pet WHERE Adoption_Status = 'Available'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $availablePets = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Loop through each available pet and display image and name

            foreach ($availablePets as $pet) {
                ?>
                    <div class="pet">
        <img src="<?php echo htmlspecialchars($pet['ImageURL']); ?>" 
             alt="<?php echo htmlspecialchars($pet['Name']); ?>" 
             class="interactive-image"
             onclick="openPopup('<?php echo htmlspecialchars($pet['Name']); ?>',
                                '<?php echo htmlspecialchars($pet['ImageURL']); ?>',
                                '<?php echo htmlspecialchars($pet['Age']); ?>',
                                '<?php echo htmlspecialchars($pet['Gender']); ?>',
                                '<?php echo htmlspecialchars($pet['Year_Rescued']); ?>',
                                '<?php echo htmlspecialchars($pet['Health']); ?>',
                                '<?php echo htmlspecialchars($pet['Description']); ?>')">
        <p class="pet-name"><?php echo htmlspecialchars($pet['Name']); ?></p>
    </div>
    <?php
}   
?>
</div>
<div id="imagePopup" class="popup" style="display: none;">
    <div class="popup-card">
        <span class="close" onclick="closePopup()">&times;</span>
        <img class="popup-content" id="popupImage" alt="Pet Image">
        <div class="popup-text">
            <h1 id="popupTitle">Title</h1>
            <hr class="separator">
            <b>Age: </b><span id="popupAge"></span>
            <hr class="separator">
            <b>Sex: </b><span id="popupSex"></span>
            <hr class="separator">
            <b>Year Rescued: </b><span id="popupYearRescued"></span>
            <hr class="separator">
            <b>Health: </b><span id="popupHealth"></span>
            <hr class="separator">
            <p id="popupDetails"></p>
            <button type="button" class="btnApply" onclick="openForm()">Adopt Now!</button>
        </div>
    </div>
</div>
    <script src="image.js"></script>

    </footer>
    <div class="footer-container">
        <div class="logo-footer"><i class="fa-solid fa-house-chimney"></i> FUR-EVER BAHAY</div>
        <div class="row">
            <a href="https://web.facebook.com/pawsphilippines" target="_blank"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://www.instagram.com/pawsphilippines" target="_blank"><i class="fa-brands fa-instagram"></i></a>
        </div>
        <div class="footer-content">
            <div class="footer-nav">
                <h3>ABOUT US</h3>
                <p>Our main job is to teach people about animal welfare...</p>
            </div>
            <div class="footer-nav">
                <h3>HOW TO REACH US?</h3>
                <p>Address: University of Mindanao, Matina Pangi Rd, Davao City</p>
                <p>Contact Number: 09693628992</p>
                <p>Email: petadoptionsystem@gmail.com</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024; Designed by: Pet Adoption System</p>
        </div>
    </div>

    <script>
        const navLinks = document.querySelectorAll('.nav-items a');
        navLinks.forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
            }
        });
    </script>
</body>
</html>
