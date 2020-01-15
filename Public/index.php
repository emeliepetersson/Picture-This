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
                        <?php require __DIR__ . '/views/post.php'; ?>
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
