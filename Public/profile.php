<?php
require __DIR__ . '/views/header.php';

if (!isset($_SESSION['user'])) { // Make this into a function!!!
    redirect('/');
}

$userPosts = displayPostsFromUser($pdo);

//Sort all posts by id to get the latest uploaded posts on top of the page
$postId = array_column($userPosts, 'id');
array_multisort($postId, SORT_DESC, $userPosts);

$userId = (string) $_SESSION['user']['id']; //convert user id into string to be able to use it in the function to get data from table
$userProfile = getOneColumnFromTable($pdo, 'biography, profile_image', 'user_profiles', 'user_id', $userId);
?>

<header class="profile">
    <img class="profile-image" src="/<?php echo $userProfile['profile_image'] ? 'uploads/' . $userProfile['profile_image'] : 'images/profile-picture.png' ?>" alt="profile image" width="100px">
    <div class="biography">
        <h2>
            <?php echo $_SESSION['user']['first_name'] . " " . $_SESSION['user']['last_name']; ?>
        </h2>
        <p><?php echo $userProfile['biography'] ?></p>
    </div>
    <a class="button small-button" href="/settings.php">Edit profile</a>
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
                <img class="profile-image" src="/uploads/<?php echo $post['profile_image'] ?>" alt="profile image">
                <h2>
                    <?php echo $post['first_name'] . " " . $post['last_name']; ?>
                </h2>
                <footer><?php echo $post['date'] ?></footer>
            </header>

            <div class="post-image">
                <img src="/uploads/<?php echo $post['image'] ?>" alt="uploaded post">
            </div>


            <div class="description-container">
                <?php
                $postIsliked = getLikes($pdo, "post_id, user_id", "likes", "post_id", "user_id", (int) $post['id'], $_SESSION['user']['id']);
                $amountOfLikes = count(getDataAsArrayFromTable($pdo, "post_id", "likes", "post_id", $post['id']));
                ?>
                <div class="likes-container">
                    <?php if (!$postIsliked) : ?>
                        <a class="like" href="/app/posts/like.php?location=profile.php&id=<?php echo $post['id'] ?>"><img src="/images/like.svg" alt="heart shaped like button"></a>
                    <?php else : ?>
                        <a class="dislike" href="/app/posts/dislike.php?location=profile.php&id=<?php echo  $post['id'] ?>"> <img src="/images/dislike.svg" alt="heart shaped dislike button"></a>
                    <?php endif; ?>
                    <p class="like-counter"><?php echo $amountOfLikes ?></p>
                </div>
                <div class="forms">
                    <form class="delete" action='/app/posts/delete.php' method="post">
                        <input type="hidden" name="post-id" value="<?php echo $post['id'] ?>">
                        <input type="hidden" name="post-name" value="<?php echo $post['image'] ?>">
                        <button type="submit" class="button smaller-button">Delete</button>
                    </form>
                    <form class="edit" action='/app/posts/edit.php' method="post">
                        <input type="hidden" name="post-id" value="<?php echo $post['id'] ?>">
                        <button type="button" class="edit-button button smaller-button">Edit</button>
                    </form>
                </div>
                <p class="description"><?php echo $post['description'] ?></p>
            </div>
        </article>
    <?php endforeach; ?>
<?php endif; ?>
<?php require __DIR__ . '/views/bottom-bar.php'; ?>
<?php require __DIR__ . '/views/footer.php'; ?>
