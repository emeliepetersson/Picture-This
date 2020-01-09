"use strict";

const deleteButtons = document.querySelectorAll(".delete-button");
const background = document.querySelector(".background");

deleteButtons.forEach(deleteButton => {
  deleteButton.addEventListener("click", showDeleteForm);
});

//when clicking on delete button, show delete form with another delete button and a cancel button
function showDeleteForm(event) {
  const deleteForm = event.currentTarget.nextElementSibling;
  deleteForm.classList.add("show");
  background.classList.add("show");

  const cancelButton = event.currentTarget.nextElementSibling.childNodes[7];

  cancelButton.addEventListener("click", hideDeleteForm);
  event.currentTarget.removeEventListener("click", showDeleteForm);
}

//when clicking on cancel, hide the delete form
function hideDeleteForm(event) {
  const deleteForm = event.currentTarget.parentNode;
  deleteForm.classList.remove("show");
  background.classList.remove("show");
  event.currentTarget.classList.add("hide");

  const deleteButton = event.currentTarget.parentNode.parentNode.childNodes[3];
  deleteButton.addEventListener("click", showDeleteForm);
}
