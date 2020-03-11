<?php require __DIR__.'/views/header.php'; ?>

<article class="create-account">
    <h1>Create account</h1>

    <form action="app/users/signup.php" method="post">

        <?php require __DIR__.'/views/errors.php'; ?>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="example@email.com" required>
        </div>

        <div class="form-group">
            <label for="first-name">First name</label>
            <input type="name" name="first-name" placeholder="First name" required>
        </div>

        <div class="form-group">
            <label for="last-name">Last name</label>
            <input type="name" name="last-name" placeholder="Last name" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="confirm-password">Confirm password</label>
            <input type="password" name="confirm-password" required>
        </div>

        <button type="submit" class="button">Create account</button>
    </form>
</article>

<?php require __DIR__.'/views/footer.php'; ?>
