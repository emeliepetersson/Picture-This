"use strict";

// in this file comment buttons are handled

commentBtns = document.querySelectorAll(".comment-btn");

commentBtns.forEach(btn => {
  btn.addEventlistener("click", e => {
    console.log(e);
  });
});
