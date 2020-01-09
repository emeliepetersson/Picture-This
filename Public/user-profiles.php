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
    $userAlreadyFollow = getDataWithTwoConditions($pdo, "user_id, following_user_id", "followers", "user_id", "following_user_id", $_SESSION['user']['id'], $userId);

    //Sort all posts by id to get the latest uploaded posts on top of the page
    $postId = array_column($userPosts, 'id');
    array_multisort($postId, SORT_DESC, $userPosts);

    $followings = getFollowers($pdo, "user_id", $userId, "following_user_id");
    $followers = getFollowers($pdo, "following_user_id", $userId, "user_id");
}

?>
<?php foreach ($errors as $error) : ?>
    <div class="error">
        <?php echo $error; ?>
    </div><!-- /alert -->
<?php endforeach; ?>
<?php foreach ($messages as $message) : ?>
    <div class="message">
        <?php echo $message; ?>
    </div><!-- /alert -->
<?php endforeach; ?>

<div class="background"></div>
<header class="profile">
    <div class="profile-picture">
        <img class="profile-image" src="/<?php echo $userBio['profile_image'] ? 'uploads/' . $userBio['profile_image'] : 'images/profile-picture.png' ?>" alt="profile image" width="100px">

        <form class="follow-form" action="/app/users/<?php echo $userAlreadyFollow ? 'unfollow.php' : 'follow.php' ?>" method="post">
            <input type="hidden" name="user-id" value="<?php echo $userId ?>">
            <button type="submit" class="follow-button button smaller-button"><?php echo $userAlreadyFollow ? 'Unfollow' : 'Follow' ?></button>
        </form>

    </div>

    <div class="biography">
        <h2>
            <?php echo $userInfo['first_name'] . " " . $userInfo['last_name']; ?>
        </h2>
        <p><?php echo $userBio['biography'] ?></p>
        <div class="follow-lists">
            <button class="button small-button followers-button">Followers</button>
            <ul class="followers-list">
                <h3>Followers</h3>
                <?php foreach ($followers as $follower) : ?>
                    <li><a href="/user-profiles.php?user-id=<?php echo $follower['user_id'] ?>"><?php echo $follower['first_name'] . " " . $follower['last_name'] ?></a></li>
                <?php endforeach; ?>
                <button class="button small-button back" type="button">Back</button>
            </ul>
            <button class="button small-button following-button">Following</button>
            <ul class="following-list">
                <h3>Following</h3>
                <?php foreach ($followings as $following) : ?>
                    <li><a href="/user-profiles.php?user-id=<?php echo $following['following_user_id'] ?>"><?php echo $following['first_name'] . " " . $following['last_name'] ?></a></li>
                <?php endforeach; ?>
                <button class="button small-button back" type="button">Back</button>
            </ul>
        </div>
    </div>
</header>
<?php if (!$userPosts) : ?>
    <p>There is no photos...</p>
<?php else : ?>
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
                $postIsliked = getDataWithTwoConditions($pdo, "post_id, user_id", "likes", "post_id", "user_id", (int) $post['id'], $_SESSION['user']['id']);
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
