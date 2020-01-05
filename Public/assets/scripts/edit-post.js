"use strict";

const editButtons = document.querySelectorAll(".edit-button");

//Add form with textarea and submit button to change the description of the post
function editMode(event) {
  event.currentTarget.textContent = "Cancel";
  const description = event.currentTarget.parentNode.nextElementSibling;
  description.classList.add("hide");
  const form = event.currentTarget.parentElement;

  const textarea = document.createElement("textarea");
  textarea.name = "description";
  textarea.maxLength = "255";
  textarea.textContent = description.textContent;
  form.appendChild(textarea);

  const submitButton = document.createElement("button");
  submitButton.classList.add("save");
  submitButton.type = "submit";
  submitButton.textContent = "Save";
  form.appendChild(submitButton);
}

// THIS DOESN'T WORK YET
editButtons.forEach(editButton => {
  if (editButton.textContent === "Cancel") {
    editButton.addEventListener("click", quitEditMode);
  } else {
    editButton.addEventListener("click", editMode);
  }
});

function quitEditMode(event) {
  event.preventDefault();
  const description = event.currentTarget.parentNode.nextElementSibling;
  description.classList.add("show");
  const submitButton = document.querySelector(".save");
  submitButton.remove();
}
