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

        if (comments.length != 0) {
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
                  <div class="comment-button-container">
                      <form class="edit-comment-form hide">
                          <input class="hidden" type="hidden" name="edit-comment-id" value="${comment.id}">
                          <input class="hidden" type="text" name="edit-comment-content" value="${comment.content}">
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
    }).then(getComments());
  };

  const editComment = e => {
    e.preventDefault();
    console.log(e);

    // const editCommentData = new FormData();
    // editCommentData.append("comment", something.value);
    // editCommentData.append("post_id", commentPostId.value);

    // fetch("/app/comments/edit.php", {
    //   method: "POST",
    //   body: editCommentData
    // }).then(getComments());
  };

  const deleteComment = e => {
    e.preventDefault();

    console.log(e);

    // const deleteCommentData = new FormData();
    // deleteCommentData.append("comment", something.value);
    // deleteCommentData.append("post_id", commentPostId.value);

    // fetch("/app/comments/delete.php", {
    //   method: "POST",
    //   body: datathing
    // }).then(getComments());
  };

  getComments();
}
