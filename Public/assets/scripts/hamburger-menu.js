"use strict";

const hamburgerIcon = document.querySelector(".hamburger-icon");
const menuItems = document.querySelector(".menu-items");
const menuContainer = document.querySelector(".menu");

// Function toggles between class names to show/hide menu items and change styling to menu and icon.
hamburgerIcon.addEventListener("click", () => {
  menuItems.classList.toggle("showMenu");
  menuContainer.classList.toggle("changeBackground");
  hamburgerIcon.classList.toggle("change");
});

// Function hides menu when window innerWidth is larger than 400 and the menu is displayed
window.addEventListener("resize", function() {
  if (
    window.innerWidth > 400 &&
    menuContainer.classList.contains("changeBackground")
  ) {
    menuContainer.classList.remove("changeBackground");
    menuItems.classList.remove("showMenu");
    hamburgerIcon.classList.remove("change");
  }
});
