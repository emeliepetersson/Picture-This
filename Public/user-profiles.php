<?php
require __DIR__ . '/views/header.php';

if (!isset($_SESSION['user'])) { // Make this into a function!!!
    redirect('/');
}
if (isset($_GET['user-id'])) {
    $userId = (int) trim(filter_var($_GET['user-id'], FILTER_SANITIZE_NUMBER_INT));
    $userPosts = displayPostsFromUser($pdo, $userId);
    $userBio = getOneColumnFromTable($pdo, 'biography, profile_image', 'user_profiles', 'user_id', $userId);
    $userInfo = getOneColumnFromTable($pdo, 'first_name, last_name', 'users', 'id', $userId);

    //Sort all posts by id to get the latest uploaded posts on top of the page
    $postId = array_column($userPosts, 'id');
    array_multisort($postId, SORT_DESC, $userPosts);
}

?>

<header class="profile">
    <img class="profile-image" src="/<?php echo $userBio['profile_image'] ? 'uploads/' . $userBio['profile_image'] : 'images/profile-picture.png' ?>" alt="profile image" width="100px">
    <div class="biography">
        <h2>
            <?php echo $userInfo['first_name'] . " " . $userInfo['last_name']; ?>
        </h2>
        <p><?php echo $userBio['biography'] ?></p>
    </div>
    <div class="forms">
        <form class="follow" action='/app/users/follow.php' method="post">
            <input type="hidden" name="user-id" value="<?php echo $userId ?>">
            <button type="button" class="follow-button button smaller-button">Follow</button>
        </form>
        <form class="unfollow" action='/app/users/unfollow.php' method="post">
            <input type="hidden" name="user-id" value="<?php echo $userId ?>">
            <button type="button" class="unfollow-button edit-button button smaller-button">Unfollow</button>
        </form>
    </div>
</header>
<?php if (!$userPosts) : ?>
    <p>There is no photos...</p>
<?php else : ?>
    <?php foreach ($messages as $message) : ?>
        <div class="message">
            <?php echo $message; ?>
        </div><!-- /alert -->
    <?php endforeach; ?>
    <?php foreach ($userPosts as $post) : ?>
        <article class="post">

            <header>
                <img class="profile-image" src="/uploads/<?php echo $post['profile_image'] ?>" alt="profile image" loading="lazy">
                <h2>
                    <?php echo $post['first_name'] . " " . $post['last_name']; ?>
                </h2>
                <footer><?php echo $post['date'] ?></footer>
            </header>

            <div class="post-image">
                <img src="/uploads/<?php echo $post['image'] ?>" alt="uploaded post" loading="lazy">
            </div>


            <div class="description-container">
                <?php
                $postIsliked = getLikes($pdo, "post_id, user_id", "likes", "post_id", "user_id", (int) $post['id'], $_SESSION['user']['id']);
                $amountOfLikes = count(getDataAsArrayFromTable($pdo, "post_id", "likes", "post_id", $post['id']));
                ?>
                <div class="likes-container">
                    <?php if (!$postIsliked) : ?>
                        <a class="like" href="/app/posts/like.php?location=user-profiles.php&user-id=<?php echo $userId ?>=&id=<?php echo $post['id'] ?>"><img src="/images/like.svg" alt="heart shaped like button"></a>
                    <?php else : ?>
                        <a class="dislike" href="/app/posts/dislike.php?location=user-profiles.php&user-id=<?php echo $userId ?>&id=<?php echo  $post['id'] ?>"> <img src="/images/dislike.svg" alt="heart shaped dislike button"></a>
                    <?php endif; ?>
                    <p class="like-counter"><?php echo $amountOfLikes ?></p>
                </div>
                <p class="description"><?php echo $post['description'] ?></p>
            </div>
        </article>
    <?php endforeach; ?>
<?php endif; ?>

<?php require __DIR__ . '/views/bottom-bar.php'; ?>
<?php require __DIR__ . '/views/footer.php'; ?>
