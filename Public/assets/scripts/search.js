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
      .then(posts => {
        searchResults.innerHTML = "";

        // console.log(posts);

        if (posts != "No posts found") {
          posts.forEach(post => {
            console.log(post);

            const template = `
            <div>
            <header>
            <img class="profile-image" src="/<?php echo $post['profile_image'] ? 'uploads/' . $post['profile_image'] : 'images/profile-picture.png' ?>" alt="profile image" loading="lazy">
            <?php if ((int) $post['user_id'] === $_SESSION['user']['id']) : ?>
                <a href="/profile.php">
                    <h2>
                        <?php echo $post['first_name'] . " " . $post['last_name']; ?>
                    </h2>
                </a>
            <?php else : ?>
                <a href="/user-profiles.php?user-id=<?php echo $post['user_id'] ?>">
                    <h2>
                        <?php echo $post['first_name'] . " " . $post['last_name']; ?>
                    </h2>
                </a>
            <?php endif; ?>
            <p class="date"><?php echo $post['date'] ?></p>
        </header>
        <div class="post-image">
            <img src="/uploads/<?php echo $post['image'] ?>" alt="uploaded post" loading="lazy">
        </div>
        
        
        <div class="caption-container">
            <?php
            $postIsliked = getDataWithTwoConditions($pdo, "post_id, user_id", "likes", "post_id", "user_id", (int) $post['id'], $_SESSION['user']['id']);
            $amountOfLikes = count(getDataAsArrayFromTable($pdo, "post_id", "likes", "post_id", $post['id']));
            ?>
            <div class="likes-container">
                <?php require __DIR__ . '/like-form.php'; ?>
            </div>
            <p class="caption"><span class="bold"><?php echo $post['first_name'] . " " . $post['last_name'] . " " ?></span> <?php echo $post['description'] ?></p>
        </div>
        </div>
        `;
            searchResults.innerHTML += template;
          });
        }
      })
      .catch(console.error);
  });
}
