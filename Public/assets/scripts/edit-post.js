"use strict";

const postIdLink = document.querySelector(".post-id-link");
const editButton = document.querySelector(".edit-button");
const post = document.querySelector(".post");

//prevent page reload when clicking on link, the link is only there to get the post-id in the url.
postIdLink.addEventListener("click", function(event) {
  event.preventDefault();
});

//Add form with textarea and submit button to change the description of the post
function editMode() {
  const description = document.querySelector(".description");
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
  post.appendChild(editForm);
}

editButton.addEventListener("click", editMode);
