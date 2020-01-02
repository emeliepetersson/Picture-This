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
                    <header>
                        <img src="/uploads/<?php echo $post['image'] ?>" alt="">
                        <form action="/app/posts/like.php" method="post" class="like-form">
                            <button class="like" type="submit"><img src="/images/like.svg" alt="like button"></button>
                            <button class="dislike" type="submit"><img src="/images/dislike.svg" alt="dislike button"></button>
                        </form>
                        <p class="like-counter">0</p>
                        <p><?php echo $post['description'] ?></p>
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
