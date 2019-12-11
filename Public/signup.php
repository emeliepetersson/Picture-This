<?php require __DIR__ . '/views/header.php'; ?>

<article>
    <h1>Create account</h1>

    <?php if (isset($error)) : ?>
        <p><?php echo $error ?></p>
    <?php endif; ?>

    <form action="app/users/signup.php" method="post">
        <?php foreach ($errors as $error) : ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div><!-- /alert -->
        <?php endforeach; ?>
        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" placeholder="example@email.com" required>
            <small class="form-text text-muted">Please provide the your email address.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="first-name">First name</label>
            <input class="form-control" type="name" name="first-name" placeholder="First name" required>
            <small class="form-text text-muted">Please provide the your first name.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="last-name">Last name</label>
            <input class="form-control" type="name" name="last-name" placeholder="Last name" required>
            <small class="form-text text-muted">Please provide the your last name.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" type="password" name="password" required>
            <small class="form-text text-muted">Please provide your password.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="password">Confirm password</label>
            <input class="form-control" type="password" name="confirm-password" required>
            <small class="form-text text-muted">Please confirm your password.</small>
        </div><!-- /form-group -->

        <button type="submit" class="btn btn-primary">Create account</button>
    </form>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
