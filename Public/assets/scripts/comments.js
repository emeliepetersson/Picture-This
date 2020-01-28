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
                  <div class="profile">
                      <img class="profile-image" src="/${comment.profile_image}" alt="profile image" loading="lazy">
                      <a href="${comment.profile_url}${comment.user_id}">
                          <h2>
                              ${comment.first_name} ${comment.last_name}
                          </h2>
                      </a>
                      <p>${comment.date}</p>
                  </div>
                  <div class="comment-text">${comment.content}</div>
                  <div class="comment-button-container">
                      <button class="comment-edit"><img src="" alt="Edit"></button>
                      <button class="comment-delete"><img src="" alt="Delete"></button>
                  </div>
              </div>
              `;
            } else {
              commentTemplate = `
              <div class="comment">
                  <div class="profile">
                      <img class="profile-image" src="/${comment.profile_image}" alt="profile image" loading="lazy">
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
        } else {
          commentContainer.textContent = "Be the first to comment!";
        }
      });
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

  const editComment = () => {
    const editCommentData = new FormData();
    editCommentData.append("comment", something.value);
    editCommentData.append("post_id", commentPostId.value);

    fetch("/app/comments/edit.php", {
      method: "POST",
      body: editCommentData
    }).then(getComments());
  };

  const deleteComment = () => {
    const datathing = new FormData();
    datathing.append("comment", something.value);
    datathing.append("post_id", commentPostId.value);

    fetch("/app/comments/delete.php", {
      method: "POST",
      body: datathing
    }).then(getComments());
  };

  if (commentContainer != undefined) {
    getComments();
  }
}
