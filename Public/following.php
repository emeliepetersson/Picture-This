<?php
require __DIR__ . '/views/header.php';

isLoggedIn();

$followings = getFollowing($pdo);

//Sort all posts by id to get the latest uploaded posts on top of the page
$postId = array_column($followings, 'id');
array_multisort($postId, SORT_DESC, $followings);

?>
<h1>Friends</h1>
<?php if (!$followings) : ?>
    <p>There is no photos...</p>
<?php else : ?>
    <?php foreach ($followings as $post) : ?>
        <article class="post">
            <?php require __DIR__ . '/views/post.php'; ?>
        </article>
    <?php endforeach; ?>
<?php endif; ?>
<?php require __DIR__ . '/views/bottom-bar.php'; ?>


<?php require __DIR__ . '/views/footer.php'; ?>
