"use strict";

const editButtons = document.querySelectorAll(".edit-button");

//Add textarea and submit button to form to change the description of the post
function editMode(event) {
  // Change edit-button to cancel-button and add quitEditMode function to eventlistener
  event.currentTarget.textContent = "Cancel";
  editButtons.forEach(editButton => {
    editButton.removeEventListener("click", editMode);
    editButton.classList.add("cancel");
  });
  event.currentTarget.addEventListener("click", quitEditMode);

  // Get the description paragraph nearest the current target and hide it when in edit mode
  const description =
    event.currentTarget.parentNode.parentNode.nextElementSibling;
  description.classList.toggle("hide");

  //Get the form element that the current target is child of and add textarea and save-button
  const form = event.currentTarget.parentElement;
  form.classList.add("edit-mode");
  const textarea = document.createElement("textarea");
  textarea.classList.add("description-textarea");
  textarea.name = "description";
  textarea.maxLength = "255";
  textarea.textContent = description.childNodes[1].nodeValue;
  form.appendChild(textarea);

  const submitButton = document.createElement("button");
  submitButton.classList.add("save");
  submitButton.classList.add("button");
  submitButton.classList.add("smaller-button");
  submitButton.type = "submit";
  submitButton.textContent = "Save";
  form.appendChild(submitButton);
}

//Remove textarea and submitbutton to cancel the edit mode
function quitEditMode(event) {
  //Change the button back to contain "edit" and add editMode function to eventlistener
  event.currentTarget.textContent = "Edit";
  editButtons.forEach(editButton => {
    editButton.addEventListener("click", editMode);
    editButton.removeEventListener("click", quitEditMode);
    editButton.classList.remove("cancel");
  });

  //Remove edit-mode class from form
  const form = event.currentTarget.parentElement;
  form.classList.remove("edit-mode");

  // Show the description paragraph again, and remove textarea and save button from the form
  const description =
    event.currentTarget.parentNode.parentNode.nextElementSibling;
  description.classList.toggle("hide");
  const submitButton = document.querySelector(".save");
  submitButton.parentNode.removeChild(submitButton);
  const textarea = document.querySelector(".description-textarea");
  textarea.parentNode.removeChild(textarea);
}

editButtons.forEach(editButton => {
  editButton.addEventListener("click", editMode);
});
