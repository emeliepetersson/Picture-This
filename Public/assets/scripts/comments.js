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
        console.log(comments);

        if (comments.length != 0 && comments != "Post not found.") {
          comments.forEach(comment => {
            console.log(comment);

            if (comment.profile_image === "") {
              comment.profile_image = "images/profile-picture.png";
            } else {
              comment.profile_image = "uploads/" + comment.profile_image;
            }

            console.log(currentUserId);

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
                      <form class="edit-comment-form hide">
                          <input class="hidden" type="hidden" name="edit-comment-id" value="${comment.id}">
                          <input class="hidden" type="text" name="edit-comment-content" value="${comment.content}">
                          <button class="button smaller-button comment-confirm-edit-btn">Save</button>
                          <button class="button smaller-button comment-cancel-edit-btn">Cancel</button>
                      </form>
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
          console.log(commentDeleteBtns);
          console.log(commentEditBtns);
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
    console.log(e);

    console.log(e.target.parentElement);
    const editForm = e.target.parentElement.firstElementChild;
    // let otherBtn = e.nextElementSibling;

    editForm.classList.remove("hide");
    e.target.textContent = "Cancel";
    e.target.removeEventListener("click", editComment);
    e.target.addEventListener("click", cancelEdit);
    // otherBtn.addEventListener("click", cancelEdit);

    // const editCommentData = new FormData();
    // editCommentData.append("comment", something.value);
    // editCommentData.append("post_id", commentPostId.value);

    // fetch("/app/comments/edit.php", {
    //   method: "POST",
    //   body: editCommentData
    // }).then(getComments());
  };

  const cancelEdit = e => {
    let editForm = e.target.parentElement.firstElementChild;
    editForm.classList.add("hide");
    e.target.textContent = "Cancel";
    e.target.removeEventListener("click", cancelEdit);
    e.target.addEventListener("click", editComment);
    // editForm.children;
  };

  const confirmEdit = e => {};

  const deleteComment = e => {
    e.preventDefault();
    let targetComment = e.target.parentElement;

    console.log(e);
    console.log(targetComment.dataset.id);
    console.log(targetComment.dataset.pid);

    const deleteCommentData = new FormData();
    deleteCommentData.append("comment-id", targetComment.dataset.id);
    deleteCommentData.append("post-id", targetComment.dataset.pid);

    fetch("/app/comments/delete.php", {
      method: "POST",
      body: deleteCommentData
    }).then(() => {
      targetComment.parentElement.remove();
    });
  };

  getComments();
}
