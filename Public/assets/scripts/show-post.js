"use strict";

const thumbnails = document.querySelectorAll(".thumbnail-post");

thumbnails.forEach(thumbnail => {
  thumbnail.addEventListener("click", showPost);
});

function showPost(event) {
  const post = event.currentTarget.nextElementSibling;
  const background = document.querySelector(".background");
  background.classList.add("background-show");
  post.classList.add("full-post-show");

  const closeButton = post.childNodes[1];
  closeButton.addEventListener("click", closePost);
}

function closePost(event) {
  const post = event.currentTarget.parentNode;
  const background = document.querySelector(".background");
  background.classList.remove("background-show");
  post.classList.remove("full-post-show");
}
