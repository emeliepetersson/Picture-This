"use strict";

// in this file comment buttons are handled

const commentContainer = document.querySelector(".comment-container");
const commentContent = document.querySelector(".comment-content");
const commentPostId = document.querySelector("#post-id");
const currentUserIdElement = document.querySelector("#user-id");
const createCommentBtn = document.querySelector(".comment-submit");
let commentTemplate = ``;

if (commentContainer != undefined) {
  const currentUserId = currentUserIdElement.value;

  createCommentBtn.addEventListener("click", () => {
    createComment();
  });

  const getComments = () => {
    const getCommentsData = new FormData();
    getCommentsData.append("post_id", commentPostId.value);

    fetch("/app/comments/read.php", {
      method: "POST",
      body: getCommentsData
    })
      .then(response => response.json())
      .then(comments => {
        if (comments.length != 0 && comments != "Post not found.") {
          comments.forEach(comment => {
            if (comment.profile_image === "") {
              comment.profile_image = "images/profile-picture.png";
            } else {
              comment.profile_image = "uploads/" + comment.profile_image;
            }

            if (parseInt(comment.user_id) === parseInt(currentUserId)) {
              commentTemplate = `
              <div class="comment">
                  <div class="profile comment-profile">
                      <img class="profile-image comment-profile-image" src="/${comment.profile_image}" alt="profile image" loading="lazy">
                      <a href="${comment.profile_url}${comment.user_id}">
                          <h2>
                              ${comment.first_name} ${comment.last_name}
                          </h2>
                      </a>
                      <p>${comment.date}</p>
                  </div>
                  <div class="comment-text">${comment.content}</div>
                  <div class="comment-button-container" data-id="${comment.id}" data-pid="${comment.post_id}">
                      <input class="edit-comment-content hide" type="text" name="edit-comment-content" value="${comment.content}">
                      <input type="hidden" name="edit-comment-id" value="${comment.id}">
                      <button class="button smaller-button comment-edit-btn">Edit</button>
                      <button class="button smaller-button comment-delete-btn">Delete</button>
                  </div>
                  
              </div>
              `;
            } else {
              commentTemplate = `
              <div class="comment">
                  <div class="profile comment-profile">
                      <img class="profile-image comment-profile-image" src="/${comment.profile_image}" alt="profile image" loading="lazy">
                      <a href="${comment.profile_url}${comment.user_id}">
                          <h2>
                              ${comment.first_name} ${comment.last_name}
                          </h2>
                      </a>
                      <p>${comment.date}</p>
                  </div>
                  <div class="comment-text">${comment.content}</div>
              </div>
              `;
            }
            commentContainer.innerHTML += commentTemplate;
          });
          const commentEditBtns = document.querySelectorAll(
            ".comment-edit-btn"
          );
          const commentDeleteBtns = document.querySelectorAll(
            ".comment-delete-btn"
          );

          commentEditBtns.forEach(editBtn => {
            editBtn.addEventListener("click", editComment);
          });
          commentDeleteBtns.forEach(deleteBtn => {
            deleteBtn.addEventListener("click", deleteComment);
          });
        } else if (comments === "Post not found.") {
          commentContainer.textContent = comments;
        } else {
          commentContainer.textContent = "Be the first to comment!";
        }
      })
      .then();
  };

  const createComment = () => {
    const newCommentData = new FormData();
    newCommentData.append("content", commentContent.value);
    newCommentData.append("post_id", commentPostId.value);

    fetch("/app/comments/create.php", {
      method: "POST",
      body: newCommentData
    }).then(() => {
      commentContent.value = "";
      commentContainer.innerHTML = "";
      getComments();
    });
  };

  const editComment = e => {
    e.preventDefault();
    const currentBtn = e.target;
    const editInput = currentBtn.parentElement.firstElementChild;
    const commentContent = currentBtn.parentElement.parentElement.children[1];
    const otherBtn = currentBtn.nextElementSibling;

    commentContent.classList.add("hide");
    editInput.classList.remove("hide");
    currentBtn.textContent = "Cancel";
    otherBtn.textContent = "Edit";
    currentBtn.removeEventListener("click", editComment);
    currentBtn.addEventListener("click", cancelEdit);
    otherBtn.removeEventListener("click", deleteComment);
    otherBtn.addEventListener("click", confirmEdit);
  };

  const cancelEdit = e => {
    e.preventDefault();
    const currentBtn = e.target;
    const editInput = currentBtn.parentElement.firstElementChild;
    const commentContent = currentBtn.parentElement.parentElement.children[1];
    const otherBtn = currentBtn.nextElementSibling;

    currentBtn.textContent = "Edit";
    otherBtn.textContent = "Delete";

    currentBtn.removeEventListener("click", cancelEdit);
    currentBtn.addEventListener("click", editComment);
    otherBtn.removeEventListener("click", confirmEdit);
    otherBtn.addEventListener("click", deleteComment);
    reshowComment(editInput, commentContent);
  };

  const confirmEdit = e => {
    e.preventDefault();
    const currentBtn = e.target;
    const comment = e.target.parentElement;
    const editInput = currentBtn.parentElement.firstElementChild;
    const commentContent = currentBtn.parentElement.parentElement.children[1];
    const otherBtn = currentBtn.previousElementSibling;

    const editCommentData = new FormData();
    editCommentData.append("content", editInput.value);
    editCommentData.append("post-id", comment.dataset.pid);
    editCommentData.append("comment-id", comment.dataset.id);

    fetch("/app/comments/edit.php", {
      method: "POST",
      body: editCommentData
    }).then(() => {
      commentContent.textContent = editInput.value;
      otherBtn.textContent = "Edit";
      currentBtn.textContent = "Delete";
      otherBtn.removeEventListener("click", cancelEdit);
      otherBtn.addEventListener("click", editComment);
      currentBtn.removeEventListener("click", confirmEdit);
      currentBtn.addEventListener("click", deleteComment);
      reshowComment(editInput, commentContent);
    });
  };

  const deleteComment = e => {
    e.preventDefault();
    const currentBtn = e.target;
    const otherBtn = currentBtn.previousElementSibling;

    currentBtn.textContent = "Confirm";
    otherBtn.textContent = "Cancel";
    currentBtn.removeEventListener("click", deleteComment);
    currentBtn.addEventListener("click", confirmDelete);
    otherBtn.removeEventListener("click", editComment);
    otherBtn.addEventListener("click", cancelDelete);
  };

  const cancelDelete = e => {
    e.preventDefault();
    const currentBtn = e.target;
    const otherBtn = currentBtn.nextElementSibling;
    currentBtn.textContent = "Edit";
    otherBtn.textContent = "Delete";
    currentBtn.removeEventListener("click", cancelDelete);
    currentBtn.addEventListener("click", editComment);
    otherBtn.removeEventListener("click", confirmDelete);
    otherBtn.addEventListener("click", deleteComment);
  };

  const confirmDelete = e => {
    e.preventDefault();
    const comment = e.target.parentElement;

    const deleteCommentData = new FormData();
    deleteCommentData.append("comment-id", comment.dataset.id);
    deleteCommentData.append("post-id", comment.dataset.pid);

    fetch("/app/comments/delete.php", {
      method: "POST",
      body: deleteCommentData
    }).then(() => {
      comment.parentElement.remove();
    });
  };

  const reshowComment = (editInput, commentContent) => {
    editInput.classList.add("hide");
    commentContent.classList.remove("hide");
  };

  getComments();
}
