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
    <form action="comments.php?post=<?php echo $post['id'] ?>" class="comment-form" method="post">
        <input type="text" name="post-id" value="<?php echo $post['id'] ?>" hidden>
        <button class="button smaller-button comment-form-button">Comments</button>
    </form>
</div>