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
$userProfile = getUserProfile($pdo, $userId);
?>

<header>
    <h1><?php echo $_SESSION['user']['first_name'] . " " . $_SESSION['user']['last_name']; ?></h1>
    <img src="/<?php echo $userProfile['profile_image'] ? 'uploads/' . $userProfile['profile_image'] : 'images/profile-picture.png' ?>" alt="profile image" width="100px">
    <p><?php echo $userProfile['biography'] ?></p>
    <a href="/settings.php"><button class="btn btn-primary">Edit profile</button></a>
</header>
<?php if (!$userPosts) : ?>
    <p>There is no photos...</p>
<?php else : ?>
    <?php foreach ($messages as $message) : ?>
        <div class="alert alert-success">
            <?php echo $message; ?>
        </div><!-- /alert -->
    <?php endforeach; ?>
    <?php foreach ($userPosts as $post) : ?>
        <article class="post">

            <header>
                <h2>
                    <?php echo $post['first_name'] . " " . $post['last_name']; ?>
                </h2>
                <footer><?php echo $post['date'] ?></footer>
            </header>

            <img class="post-image" src="/uploads/<?php echo $post['image'] ?>" alt="uploaded post">

            <div class="description-wrapper">
                <?php
                $postIsliked = getLikes($pdo, "post_id, user_id", "likes", "post_id", "user_id", (int) $post['id'], $_SESSION['user']['id']);
                $amountOfLikes = count(getDataAsArrayFromTable($pdo, "post_id", "likes", "post_id", $post['id']));
                ?>
                <?php if (!$postIsliked) : ?>
                    <a class="like" href="/app/posts/like.php?location=profile.php&id=<?php echo $post['id'] ?>"><img src="/images/like.svg" alt="heart shaped like button"></a>
                <?php else : ?>
                    <a class="dislike" href="/app/posts/dislike.php?location=profile.php&id=<?php echo  $post['id'] ?>"> <img src="/images/dislike.svg" alt="heart shaped dislike button"></a>
                <?php endif; ?>
                <p class="like-counter"><?php echo $amountOfLikes ?></p>
                <form action='/app/posts/delete.php' method="post">
                    <input type="hidden" name="post-id" value="<?php echo $post['id'] ?>">
                    <input type="hidden" name="post-name" value="<?php echo $post['image'] ?>">
                    <button type="submit" class="btn btn-primary">Delete</button>
                </form>
                <form action='/app/posts/edit.php' method="post">
                    <input type="hidden" name="post-id" value="<?php echo $post['id'] ?>">
                    <!-- <button type="button" class="cancel-button btn btn-primary">Cancel</button> -->
                    <button type="button" class="edit-button btn btn-primary">Edit</button>
                </form>
                <p class="description"><?php echo $post['description'] ?></p>
            </div>
        </article>
    <?php endforeach; ?>
<?php endif; ?>
<?php require __DIR__ . '/views/bottom-bar.php'; ?>
<?php require __DIR__ . '/views/footer.php'; ?>
