"use strict";

const likeForms = document.querySelectorAll(".like-form");

likeForms.forEach(form => {
  form.addEventListener("submit", sendFormData);
});

function sendFormData(event) {
  event.preventDefault();

  let likeButton = event.currentTarget.querySelector("button");
  let totalLikes = event.currentTarget.nextElementSibling;
  let likeIcon = likeButton.querySelector("img");

  if (likeButton.classList.contains("dislike")) {
    likeButton.classList.replace("dislike", "like");
    likeIcon.src = "/images/like.svg";
  } else {
    likeButton.classList.replace("like", "dislike");
    likeIcon.src = "/images/dislike.svg";
  }

  const formData = new FormData(event.currentTarget);

  fetch("/app/posts/like.php", {
    method: "POST",
    body: formData
  })
    .then(response => response.json())
    .then(likes => {
      totalLikes.innerText = likes;
    });
}
