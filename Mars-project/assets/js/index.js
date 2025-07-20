"use strict";
// funktion för att visa eller dölja navigationsmenyn
function toggleMenu() {
  const navLinks = document.getElementById("nav-menu");
  console.log(navLinks);
  navLinks.classList.toggle("active");
}


document.addEventListener("DOMContentLoaded", function () {
  

  
  const popup = document.getElementById("instruction-message");
  const closeButton = document.getElementById("close-popup");
// visar popup om användaren inte redan stängt den
  if (popup && closeButton) {
    if (!localStorage.getItem("instruktion_message")) {
      popup.classList.add("visible");
    }
// stänger popup och sparar i localStorage så den inte visas igen
    closeButton.addEventListener("click", function () {
      popup.classList.remove("visible");
      localStorage.setItem("instruktion_message", "true");
    });
  }

  // stjärnanimation i bakgrunden
  const starCount = 200;
  const starElement = document.getElementById("star");

  if (starElement) {
    for (let i = 0; i < starCount; i++) {
      const starClone = starElement.cloneNode(true);
      starClone.style.top = Math.random() * 100 + "vh"; // slumpad vertikal position
      starClone.style.left = Math.random() * 100 + "vw"; // slumpad horisontell position
      starClone.style.animationDuration = Math.random() * 3 + 2 + "s"; // slumpad animationshastighet
      document.body.appendChild(starClone);
    }

    starElement.style.display = "none"; // döljer originalelementet
  }
});