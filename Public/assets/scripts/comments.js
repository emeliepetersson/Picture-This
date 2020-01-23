"use strict";

// in this file comment buttons are handled

console.log("Loaded comments.");

const commentBtns = document.querySelectorAll(".comment-form-button");

commentBtns.forEach(btn => {
  btn.addEventListener("click", e => {
    console.log(e);
  });
});

const commentTemplate = ``;

const getComments = () => {
  const datathing = new FormData();
  datathing.append("comment", something.value);
  datathing.append("post_id", postidthing.value);

  fetch("/app/comments/read.php", {
    method: "GET",
    body: datathing
  })
    .then(response => response.json())
    .then(comments => {
      comments.forEach(comment => {
        comment["comment"];
      });
    });
};

const createComment = () => {
  const datathing = new FormData();
  datathing.append("comment", something.value);
  datathing.append("post_id", postidthing.value);

  fetch("/app/comments/create.php", {
    method: "POST",
    body: datathing
  }).then(getComments());
};

const editComment = () => {
  const datathing = new FormData();
  datathing.append("comment", something.value);
  datathing.append("post_id", postidthing.value);

  fetch("/app/comments/edit.php", {
    method: "POST",
    body: datathing
  }).then(getComments());
};

const deleteComment = () => {
  const datathing = new FormData();
  datathing.append("comment", something.value);
  datathing.append("post_id", postidthing.value);

  fetch("/app/comments/delete.php", {
    method: "POST",
    body: datathing
  }).then(getComments());
};
