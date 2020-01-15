<?php
require __DIR__ . '/views/header.php';

isLoggedIn();

$userPosts = displayPostsFromUser($pdo, (int) $_SESSION['user']['id']);

//Sort all posts by id to get the latest uploaded posts on top of the page
$postId = array_column($userPosts, 'id');
array_multisort($postId, SORT_DESC, $userPosts);

$userId = (string) $_SESSION['user']['id']; //convert user id into string to be able to use it in the function to get data from table
$userProfile = getOneColumnFromTable($pdo, 'biography, profile_image', 'user_profiles', 'user_id', $userId);

$followings = getFollowers($pdo, "user_id", (int) $userId, "following_user_id");
$followers = getFollowers($pdo, "following_user_id", (int) $userId, "user_id");

?>
<!-- background is shown when module is opened -->
<div class="background"></div>

<header class="profile">
    <img class="profile-image" src="/<?php echo $userProfile['profile_image'] ? 'uploads/' . $userProfile['profile_image'] : 'images/profile-picture.png' ?>" alt="profile image" loading="lazy">

    <div class="biography">
        <h2>
            <?php echo $_SESSION['user']['first_name'] . " " . $_SESSION['user']['last_name']; ?>
        </h2>
        <p><?php echo $userProfile['biography'] ?></p>
    </div>

    <div class="profile-buttons">
        <a class="button small-button" href="/settings.php">Edit profile</a>
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
    <?php foreach ($messages as $message) : ?>
        <div class="message">
            <?php echo $message; ?>
        </div><!-- /alert -->
    <?php endforeach; ?>
    <?php foreach ($userPosts as $post) : ?>
        <article class="post">

            <header>
                <img class="profile-image" src="/<?php echo $userProfile['profile_image'] ? 'uploads/' . $userProfile['profile_image'] : 'images/profile-picture.png' ?>" alt="profile image" loading="lazy">
                <h2>
                    <?php echo $post['first_name'] . " " . $post['last_name']; ?>
                </h2>
                <p><?php echo $post['date'] ?></p>
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
                    <form class="like-form" method="post">
                        <input type="text" name="post-id" value="<?php echo $post['id'] ?>" hidden>
                        <button type="submit" class="like-form-button <?php echo $postIsliked ? "dislike" : "like" ?>"><img src="/images/<?php echo $postIsliked ? "dislike.svg" : "like.svg" ?>" alt="like button"></button>
                    </form>
                    <p class="like-counter"><?php echo $amountOfLikes ?></p>
                </div>
                <div class="forms">
                    <button type="button" class="delete-button button smaller-button">Delete</button>
                    <form class="delete" action='/app/posts/delete.php' method="post">
                        <input type="hidden" name="post-id" value="<?php echo $post['id'] ?>">
                        <input type="hidden" name="post-name" value="<?php echo $post['image'] ?>">
                        <p>Are you sure you want to delete?</p>
                        <button type="button" class="button smaller-button cancel">Cancel</button>
                        <button type="submit" class="button smaller-button">Delete</button>
                    </form>
                    <form class="edit" action='/app/posts/edit.php' method="post">
                        <input type="hidden" name="post-id" value="<?php echo $post['id'] ?>">
                        <button type="button" class="edit-button button smaller-button">Edit</button>
                    </form>
                </div>
                <p class="caption"><span class="bold"><?php echo $post['first_name'] . " " . $post['last_name'] . " " ?></span> <?php echo $post['description'] ?></p>
            </div>
        </article>
    <?php endforeach; ?>
<?php endif; ?>
<?php require __DIR__ . '/views/bottom-bar.php'; ?>
<?php require __DIR__ . '/views/footer.php'; ?>
