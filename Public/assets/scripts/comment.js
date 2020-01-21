"use strict";

// in this file comment buttons are handled

console.log("Loaded comments.");

const commentBtns = document.querySelectorAll(".comment-form-button");

commentBtns.forEach(btn => {
  btn.addEventListener("click", e => {
    console.log(e);
  });
});
