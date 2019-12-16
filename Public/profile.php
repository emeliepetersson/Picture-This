<?php
require __DIR__ . '/views/header.php';

if (!isset($_SESSION['user'])) { // Make this into a function!!!
    redirect('/');
}

?>

<header>
    <h1><?php echo $_SESSION['user']['first_name'] . " " . $_SESSION['user']['last_name']; ?></h1>
</header>
<?php require __DIR__ . '/app/display-posts.php'; ?>
<?php if (!$userPosts) : ?>
    <p>There is no photos...</p>
<?php else : ?>
    <?php foreach ($userPosts as $post) : ?>
        <article>
            <header>
                <h2>
                    <?php echo $post['first_name'] . " " . $post['last_name']; ?>
                </h2>
                <footer><?php echo $post['date'] ?></footer>
                <header>
                    <img src="/uploads/<?php echo $post['image'] ?>" alt="">
                    <p><?php echo $post['description'] ?></p>
        </article>
    <?php endforeach; ?>
<?php endif; ?>
<?php require __DIR__ . '/views/bottom-bar.php'; ?>
<?php require __DIR__ . '/views/footer.php'; ?>
