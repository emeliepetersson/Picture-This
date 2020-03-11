<?php
require __DIR__.'/views/header.php';

isLoggedIn();

if (isset($_GET['user-id'])) {
    $userId = (int) trim(filter_var($_GET['user-id'], FILTER_SANITIZE_NUMBER_INT));
    $userPosts = displayPostsFromUser($pdo, $userId);
    $userBio = getOneColumnFromTable($pdo, 'biography, profile_image', 'user_profiles', 'user_id', $userId);
    $userInfo = getOneColumnFromTable($pdo, 'first_name, last_name', 'users', 'id', $userId);
    $userAlreadyFollow = getDataWithTwoConditions($pdo, 'user_id, following_user_id', 'followers', 'user_id', 'following_user_id', $_SESSION['user']['id'], $userId);

    //Sort all posts by id to get the latest uploaded posts on top of the page
    $postId = array_column($userPosts, 'id');
    array_multisort($postId, SORT_DESC, $userPosts);

    $followings = getFollowers($pdo, 'user_id', $userId, 'following_user_id');
    $followers = getFollowers($pdo, 'following_user_id', $userId, 'user_id');
}

?>

<?php require __DIR__.'/views/errors.php'; ?>
<?php require __DIR__.'/views/messages.php'; ?>

<!-- background is shown when module is opened -->
<div class="background"></div>

<header class="profile">
    <img class="profile-image" src="/<?php echo $userBio['profile_image'] ? 'uploads/'.$userBio['profile_image'] : 'images/profile-picture.png' ?>" alt="profile image" loading="lazy">

    <div class="biography">
        <h2>
            <?php echo $userInfo['first_name'].' '.$userInfo['last_name']; ?>
        </h2>
        <p><?php echo $userBio['biography'] ?></p>
    </div>

    <div class="profile-buttons">
        <form class="follow-form" action="/app/users/<?php echo $userAlreadyFollow ? 'unfollow.php' : 'follow.php' ?>" method="post">
            <input type="hidden" name="user-id" value="<?php echo $userId ?>">
            <button type="submit" class="follow-button button small-button"><?php echo $userAlreadyFollow ? 'Unfollow' : 'Follow' ?></button>
        </form>
        <?php require __DIR__.'/views/follow-lists.php'; ?>
    </div>

</header>
<?php if (!$userPosts) { ?>
    <p>There is no photos...</p>
<?php } else { ?>
    <?php foreach ($userPosts as $post) { ?>
        <article class="post">
            <?php require __DIR__.'/views/post.php'; ?>
        </article>
    <?php } ?>
<?php } ?>

<?php require __DIR__.'/views/bottom-bar.php'; ?>
<?php require __DIR__.'/views/footer.php'; ?>
