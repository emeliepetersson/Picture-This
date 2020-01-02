<?php
require __DIR__ . '/views/header.php';
$allPosts = displayAllPosts($pdo);
?>

<!-- The view if the user is logged in -->
<?php if (isset($_SESSION['user'])) : ?>

    <h1>Photos feed</h1>
    <?php if (!$allPosts) : ?>
        <p>There is no photos...</p>
    <?php else : ?>
        <?php foreach ($allPosts as $post) : ?>
            <article>

                <header>
                    <h2>
                        <?php echo $post['first_name'] . " " . $post['last_name']; ?>
                    </h2>
                    <footer><?php echo $post['date'] ?></footer>
                </header>

                <img src="/uploads/<?php echo $post['image'] ?>" alt="">

                <div class="description-wrapper">
                    <?php if(getLikes($pdo, "post_id, user_id", "likes", "post_id", "user_id", (int) $post['id'], $_SESSION['user']['id']) === null ): ?>
                    <a class="like" href="/app/posts/like.php?id=<?php echo $post['id'] ?>"><img src="/images/like.svg" alt="heart shaped like button"></a>
                    <?php else: ?>
                    <a class="dislike" href="/app/posts/dislike.php?id=<?php echo  $post['id'] ?>"> <img src="/images/dislike.svg" alt="heart shaped dislike button"></a>
                    <?php endif; ?>
                    <p class="like-counter">0</p>
                    <p class="description"><?php echo $post['description'] ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php require __DIR__ . '/views/bottom-bar.php'; ?>




    <!-- The view if the user is not logged in -->
<?php else : ?>
    <h1><img src="<?php echo $config['logo']; ?>" alt="Picture this logo"></h1>
    <a href="login.php">Login</a>
    <a href="signup.php">Sign up</a>
<?php endif; ?>


<?php require __DIR__ . '/views/footer.php'; ?>
