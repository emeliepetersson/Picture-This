"use strict";

const likeButton = document.querySelector(".like");
const dislikeButton = document.querySelector(".dislike");

likeButton.addEventListener("click", liker);
dislikeButton.addEventListener("click", liker);

function liker() {
  likeButton.classList.toggle("hide");
  dislikeButton.classList.toggle("show");
}
