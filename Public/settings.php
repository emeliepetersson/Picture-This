<?php
require __DIR__ . '/views/header.php';

if (!isset($_SESSION['user'])) { // Make this into a function!!!
    redirect('/');
}

?>

<article>
    <h1>Settings</h1>

    <form action="app/users/edit-settings.php" method="post">
        <?php foreach ($errors as $error) : ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div><!-- /alert -->
        <?php endforeach; ?>
        <?php foreach ($messages as $message) : ?>
            <div class="alert alert-success">
                <?php echo $message; ?>
            </div><!-- /alert -->
        <?php endforeach; ?>
        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" value="<?php echo $_SESSION['user']['email'] ?>">
            <small class="form-text text-muted">Please provide your email address.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="first-name">First name</label>
            <input class="form-control" type="name" name="first-name" value="<?php echo $_SESSION['user']['first_name'] ?>">
            <small class="form-text text-muted">Please provide your first name.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="last-name">Last name</label>
            <input class="form-control" type="name" name="last-name" value="<?php echo $_SESSION['user']['last_name'] ?>">
            <small class="form-text text-muted">Please provide your last name.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" type="password" name="password">
            <small class="form-text text-muted">Please provide your new password.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="password">Confirm password</label>
            <input class="form-control" type="password" name="confirm-password">
            <small class="form-text text-muted">Please confirm your new password.</small>
        </div><!-- /form-group -->

        <label for="image">Choose a profile image to upload</label>
        <input type="file" name="image" id="image" class="choose-file">

        <!--Preview image -->
        <div class="form-group">
            <img id="output-image" alt="image preview" />
        </div>

        <div class="form-group">
            <small class="form-text text-muted">Write your biography.</small>
            <textarea name="description" form="post" maxlength="255"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Settings</button>
    </form>
</article>

<?php require __DIR__ . '/views/bottom-bar.php'; ?>
<?php require __DIR__ . '/views/footer.php'; ?>
