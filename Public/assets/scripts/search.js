"use strict";

// this is where searching is handled
// magic fetch stuff to be made :)

console.log("Loaded search.");

const searchForm = document.querySelector(".search-form");
const searchInput = document.querySelector(".search-input");
const searchResults = document.querySelector(".search-results");

if (searchInput) {
  searchInput.addEventListener("keyup", event => {
    event.preventDefault();
    const searchData = new FormData();
    searchData.append("search", searchInput.value);
    // console.log(event);

    fetch("/app/posts/search.php", {
      method: "POST",
      body: searchData
    })
      .then(response => response.json())
      .then(usersPosts => {
        searchResults.innerHTML = "";

        console.log(usersPosts);

        if (usersPosts != "No posts found") {
          // usersPosts.forEach(userPosts => {
          console.log(usersPosts);

          usersPosts.forEach(post => {
            let likeImage;

            if (post.profile_image === "") {
              post.profile_image = "images/profile-picture.png";
            } else {
              post.profile_image = "uploads/" + post.profile_image;
            }

            if (post.like === "liked") {
              likeImage = "images/dislike.svg";
            } else {
              likeImage = "images/like.svg";
            }

            const template = `
              <article class="post">
                  <div class="post-image thumbnail-post">
                      <img src="/uploads/${post.image}" alt="uploaded post" loading="lazy">
                  </div>
                  <div class="full-post">
                      <div class="close-button-container">
                          <button class="close-button" type="button"><img class="close" src="/images/close.png" alt="close icon"></button>
                      </div>
                      <div>
                          <header>
                              <img class="profile-image" src="/${post.profile_image}" alt="profile image" loading="lazy">
                                  <a href="${post.profile_url}${post.user_id}">
                                      <h2>
                                          ${post.first_name} ${post.last_name}
                                      </h2>
                                  </a>
                              <p class="date">${post.date}</p>
                          </header>
                          <div class="post-image">
                              <img src="/uploads/${post.image}" alt="uploaded post" loading="lazy">
                          </div>

                          <div class="caption-container">
                              <div class="likes-container">
                                  <form class="like-form" method="post">
                                      <input type="text" name="post-id" value="${post.id}" hidden>
                                      <button type="submit" class="like-form-button ${post.like}"><img src="${likeImage}" alt="like button"></button>
                                  </form>
                                  <p class="like-counter">${post.likes}</p>
                                  <form class="comment-form" method="post">
                                    <input type="text" name="post-id" value="${post.id}" hidden>
                                    <button class="comment-form-button">Comment</button>
                                  </form>
                              </div>
                              <p class="caption"><span class="bold">${post.first_name} ${post.last_name} </span> ${post.description}</p>
                          </div>
                      </div>
              </article>
              `;
            searchResults.innerHTML += template;
          });

          const likeForms = document.querySelectorAll(".like-form");
          likeForms.forEach(form => {
            form.addEventListener("submit", sendFormData);
          });

          const thumbnails = document.querySelectorAll(".thumbnail-post");
          thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener("click", showPost);
          });

          const commentBtns = document.querySelectorAll(".comment-form-button");
          commentBtns.forEach(btn => {
            btn.addEventListener("submit", e => {
              console.log(e);
            });
          });
          // });
        }
      })
      .catch(console.error);
  });
}
