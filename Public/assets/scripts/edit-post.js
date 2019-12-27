"use strict";

const postIdLinks = document.querySelectorAll(".post-id-link");
const editButtons = document.querySelectorAll(".edit-button");

//prevent page reload when clicking on link, the link is only there to get the post-id in the url.
postIdLinks.forEach(postIdLink => {
  postIdLink.addEventListener("click", function(event) {
    event.preventDefault();
  });
});

//Add form with textarea and submit button to change the description of the post
function editMode(event) {
  event.currentTarget.classList.add("hide");
  const description = event.currentTarget.parentNode.nextElementSibling;
  const descriptionWrapper = event.currentTarget.parentElement;
  description.classList.add("hide");

  const editForm = document.createElement("form");
  const editTextarea = document.createElement("textarea");
  const editButton = document.createElement("button");
  editButton.innerText = "Save";
  editButton.type = "submit";
  editForm.method = "post";
  editForm.action = "app/posts/edit.php";
  editTextarea.textContent = description.textContent;
  editTextarea.name = "description";
  editTextarea.maxLength = "255";

  editForm.appendChild(editTextarea);
  editForm.appendChild(editButton);
  descriptionWrapper.appendChild(editForm);
}

editButtons.forEach(editButton => {
  editButton.addEventListener("click", editMode);
});
