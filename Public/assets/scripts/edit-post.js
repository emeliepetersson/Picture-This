"use strict";

const editButtons = document.querySelectorAll(".edit-button");

//Add form with textarea and submit button to change the description of the post
function editMode(event) {
  event.currentTarget.classList.add("hide");
  const description = event.currentTarget.parentNode.nextElementSibling;
  description.classList.add("hide");
  const form = event.currentTarget.parentElement;

  const textarea = document.createElement("textarea");
  textarea.name = "description";
  textarea.maxLength = "255";
  textarea.textContent = description.textContent;
  form.appendChild(textarea);

  const submitButton = document.createElement("button");
  submitButton.type = "submit";
  submitButton.textContent = "Save";
  form.appendChild(submitButton);
}

editButtons.forEach(editButton => {
  editButton.addEventListener("click", editMode);
});
