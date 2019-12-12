<?php require __DIR__ . '/views/header.php'; ?>

<article>
    <?php if (isset($_SESSION['user'])) : ?>
        <h1>Photos feed</h1>
        <p>There is no photos...</p>
        <?php require __DIR__ . '/views/bottom-bar.php'; ?>
    <?php else : ?>
        <h1><img src="<?php echo $config['logo']; ?>" alt="Picture this logo"></h1>
        <a href="login.php">Login</a>
        <a href="signup.php">Sign up</a>
    <?php endif; ?>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
