"use strict";

const deleteButton = document.querySelector(".delete-account-button");
const cancelButton = document.querySelector(".cancel-delete-account");

deleteButton.addEventListener("click", showDeleteAccountForm);
cancelButton.addEventListener("click", hideDeleteAccountForm);

function showDeleteAccountForm() {
  const form = document.querySelector(".delete-account-form");
  form.classList.add("delete-account-form-show");
  const background = document.querySelector(".background");
  background.classList.add("background-show");
}

function hideDeleteAccountForm() {
  const form = document.querySelector(".delete-account-form");
  form.classList.remove("delete-account-form-show");
  const background = document.querySelector(".background");
  background.classList.remove("background-show");
}
