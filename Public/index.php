<?php
require __DIR__ . '/views/header.php';
$allPosts = displayAllPosts($pdo);

//Sort all posts by id to get the latest uploaded posts on top of the page
$postId = array_column($allPosts, 'id');
array_multisort($postId, SORT_DESC, $allPosts);

?>

<?php foreach ($messages as $message) : ?>
    <div class="message">
        <?php echo $message; ?>
    </div><!-- /alert -->
<?php endforeach; ?>

<!-- The view if the user is logged in -->
<?php if (isset($_SESSION['user'])) : ?>

    <!-- background is shown when module is opened -->
    <div class="background"></div>

    <h1>Explore</h1>
    <?php if (!$allPosts) : ?>
        <p>There is no photos...</p>
    <?php else : ?>
        <div class="explore-container">
            <?php foreach ($allPosts as $post) : ?>
                <article class="post">

                    <!-- This is shown as small pictures -->
                    <div class="post-image thumbnail-post">
                        <img src="/uploads/<?php echo $post['image'] ?>" alt="uploaded post" loading="lazy">
                    </div>

                    <!-- This is shown as bigger pictures on click -->
                    <div class="full-post">
                        <div class="close-button-container">
                            <button class="close-button" type="button"><img class="close" src="/images/close.png" alt="close icon"></button>
                        </div>
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
                                <?php require __DIR__ . '/views/like-form.php'; ?>
                            </div>
                            <p class="caption"><span class="bold"><?php echo $post['first_name'] . " " . $post['last_name'] . " " ?></span> <?php echo $post['description'] ?></p>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
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
