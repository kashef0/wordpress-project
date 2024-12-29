"use strict";

function toggleMenu() {
  const navLinks = document.getElementById("nav-menu");
  navLinks.classList.toggle("active");
}

// const navLinks = document.getElementById("nav-menu");
// console.log(navLinks);
// navLinks.addEventListener("click", function () {
//   navLinks.classList.toggle("active");
// });

const starCount = 200; // Number of stars
const starElement = document.getElementById("star"); // Get the existing star element
if (starElement) {
  for (let i = 0; i < starCount; i++) {
    const starClone = starElement.cloneNode(true);
    starClone.style.top = Math.random() * 100 + "vh"; // Random vertical position
    starClone.style.left = Math.random() * 100 + "vw"; // Random horizontal position
    starClone.style.animationDuration = Math.random() * 3 + 2 + "s"; // Random twinkle duration

    // Append the cloned star to the body
    document.body.appendChild(starClone);
  }
  // Optionally, remove the original star element after cloning
  starElement.style.display = "none";
}

