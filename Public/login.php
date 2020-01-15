<?php require __DIR__ . '/views/header.php'; ?>

<article>
    <h1>Login</h1>

    <form action="app/users/login.php" method="post">

        <?php require __DIR__ . '/views/errors.php'; ?>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="email@example.com" required>
            <small>Please provide your email address.</small>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" required>
            <small>Please provide your password.</small>
        </div>

        <button type="submit" class="button">Login</button>
    </form>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
