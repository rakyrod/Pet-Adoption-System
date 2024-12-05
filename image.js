function openPopup(imageElement, title,age,year,sex,health, details) {
    var popup = document.getElementById("imagePopup");
    var popupImg = document.getElementById("popupImage");
    var popupTitle = document.getElementById("popupTitle");
    var popupAge = document.getElementById("popupAge");
    var popupYear = document.getElementById("popupYear")
    var popupSex = document.getElementById("popupSex");
    var popupHealth = document.getElementById("popupHealth");
    var popupDetails = document.getElementById("popupDetails");

    popup.style.display = "flex";
    popupImg.src = imageElement.src;
    popupTitle.innerHTML = title;
    popupAge.innerHTML = age;
    popupYear.innerHTML = year;
    popupSex.innerHTML = sex;
    popupHealth.innerHTML = health;
    popupDetails.innerHTML = details;
}

function closePopup() {
    var popup = document.getElementById("imagePopup");
    popup.style.display = "none";
}

document.getElementById("minggyImage").addEventListener("click", function() {
    openPopup(this, "Minggy", "Approx. 3 years old","2020", "Male","healthy", "description");
});

document.getElementById("stewartImage").addEventListener("click", function() {
    openPopup(this, "Stewart", "Approx. 3 years old","2023", "Male","healthy", "description");
});

document.getElementById("troyImage").addEventListener("click", function() {
    openPopup(this, "Troy", "Approx. 3 years old", "Male","2024", "healthy","description");
});

document.getElementById("luffyImage").addEventListener("click", function() {
    openPopup(this, "Luffy", "Approx. 3 years old", "Male","2023", "healthy","description");
});

function openForm() {
    
    var formUrl = "https://forms.gle/G7b8vbgmBY95AHdQ8";
    window.open(formUrl, "_blank");
}

window.onclick = function(event) {
    var popup = document.getElementById("imagePopup");
    var card = document.querySelector('.popup-card');
    if (event.target == popup && !card.contains(event.target)) {
        closePopup();
    }
}