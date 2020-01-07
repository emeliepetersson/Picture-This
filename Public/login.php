<?php require __DIR__ . '/views/header.php'; ?>

<article>
    <h1>Login</h1>

    <form action="app/users/login.php" method="post">
        <?php foreach ($errors as $error) : ?>
            <div class="error">
                <?php echo $error; ?>
            </div><!-- /alert -->
        <?php endforeach; ?>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="email@example.com" required>
            <small>Please provide your email address.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" required>
            <small>Please provide your password.</small>
        </div><!-- /form-group -->

        <button type="submit" class="button">Login</button>
    </form>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
