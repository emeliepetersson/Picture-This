"use strict";

const hamburgerIcon = document.querySelector(".hamburger-icon");
const menuItems = document.querySelector(".menu-items");
const menuContainer = document.querySelector(".menu");

// Function toggles between class names to show/hide menu items and change styling to menu and icon.
hamburgerIcon.addEventListener("click", () => {
  menuItems.classList.toggle("show-menu");
  menuContainer.classList.toggle("change-background");
  hamburgerIcon.classList.toggle("change");
});

// Function hides menu when window innerWidth is larger than 400 and the menu is displayed
window.addEventListener("resize", function() {
  if (
    window.innerWidth > 400 &&
    menuContainer.classList.contains("change-background")
  ) {
    menuContainer.classList.remove("change-background");
    menuItems.classList.remove("show-menu");
    hamburgerIcon.classList.remove("change");
  }
});
