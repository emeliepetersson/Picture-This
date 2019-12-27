"use strict";

const editButton = document.querySelector(".edit-button");
const post = document.querySelector(".post");

function editMode() {
  const description = document.querySelector(".description");
  description.classList.add("hide");

  const editForm = document.createElement("form");
  const editInput = document.createElement("input");
  const editButton = document.createElement("button");
  editButton.innerText = "Save";
  editForm.method = "post";
  editForm.action = "app/posts/edit.php";

  editInput.value = description.textContent;

  editForm.appendChild(editInput);
  editForm.appendChild(editButton);
  post.appendChild(editForm);
}

editButton.addEventListener("click", editMode);
