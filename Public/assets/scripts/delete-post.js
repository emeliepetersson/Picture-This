"use strict";

const deleteButtons = document.querySelectorAll(".delete-button");
const background = document.querySelector(".background");
const cancelButtons = document.querySelectorAll(".cancel");

cancelButtons.forEach(cancelButton => {
  cancelButton.addEventListener("click", hideDeleteForm);
});

deleteButtons.forEach(deleteButton => {
  deleteButton.addEventListener("click", showDeleteForm);
});

//when clicking on delete button, show delete form with another delete button and a cancel button
function showDeleteForm(event) {
  const deleteForm = event.currentTarget.nextElementSibling;
  deleteForm.classList.add("show");
  background.classList.add("show");
}

//when clicking on cancel, hide the delete form
function hideDeleteForm(event) {
  const deleteForm = event.currentTarget.parentNode;
  deleteForm.classList.remove("show");
  background.classList.remove("show");
  event.currentTarget.classList.add("hide");
}
