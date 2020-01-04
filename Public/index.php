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
                    <?php
                    $postIsliked = getLikes($pdo, "post_id, user_id", "likes", "post_id", "user_id", (int) $post['id'], $_SESSION['user']['id']);
                    $amountOfLikes = count(getDataAsArrayFromTable($pdo, "post_id", "likes", "post_id", $post['id']));
                    ?>
                    <?php if (!$postIsliked) : ?>
                        <a class="like" href="/app/posts/like.php?location=index.php&id=<?php echo $post['id'] ?>"><img src="/images/like.svg" alt="heart shaped like button"></a>
                    <?php else : ?>
                        <a class="dislike" href="/app/posts/dislike.php?location=index.php&id=<?php echo  $post['id'] ?>"> <img src="/images/dislike.svg" alt="heart shaped dislike button"></a>
                    <?php endif; ?>
                    <p class="like-counter"><?php echo $amountOfLikes ?></p>
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
