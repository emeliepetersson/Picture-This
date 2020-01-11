"use strict";

const thumbnails = document.querySelectorAll(".thumbnail-post");

thumbnails.forEach(thumbnail => {
  thumbnail.addEventListener("click", showPost);
});

function showPost(event) {
  const post = event.currentTarget.nextElementSibling;
  const background = document.querySelector(".background");
  background.classList.add("background-show");
  post.classList.add("show");
}
