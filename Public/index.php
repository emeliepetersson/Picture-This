<?php
require __DIR__ . '/views/header.php';
$allPosts = displayAllPosts($pdo);

//Sort all posts by id to get the latest uploaded posts on top of the page
$postId = array_column($allPosts, 'id');
array_multisort($postId, SORT_DESC, $allPosts);
?>

<!-- The view if the user is logged in -->
<?php if (isset($_SESSION['user'])) : ?>

    <h1>Photos feed</h1>
    <?php if (!$allPosts) : ?>
        <p>There is no photos...</p>
    <?php else : ?>
        <?php foreach ($allPosts as $post) : ?>
            <article class="post">

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
                    <p><?php echo $post['date'] ?></p>
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
                            <a class="like" href="/app/posts/like.php?location=index.php&id=<?php echo $post['id'] ?>"><img src="/images/like.svg" alt="heart shaped like button"></a>
                        <?php else : ?>
                            <a class="dislike" href="/app/posts/dislike.php?location=index.php&id=<?php echo  $post['id'] ?>"> <img src="/images/dislike.svg" alt="heart shaped dislike button"></a>
                        <?php endif; ?>
                        <p class="like-counter"><?php echo $amountOfLikes ?></p>
                    </div>
                    <p class="description"><?php echo $post['description'] ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php require __DIR__ . '/views/bottom-bar.php'; ?>

    <!-- The view if the user is not logged in -->
<?php else : ?>
    <img class="big-logo" src="<?php echo $config['logo']; ?>" alt="Picture this logo">
    <a class="button" href="login.php">Login</a>
    <p class="instruction">or create an account</p>
    <a class="button" href="signup.php">Sign up</a>
<?php endif; ?>


<?php require __DIR__ . '/views/footer.php'; ?>
