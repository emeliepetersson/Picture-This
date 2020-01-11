<?php
require __DIR__ . '/views/header.php';

isLoggedIn();

if (!isset($_SESSION['user'])) { // Make this into a function!!!
    redirect('/');
}

$userId = (string) $_SESSION['user']['id']; //convert user id into string to be able to use it in the function to get data from table
$userProfile = getOneColumnFromTable($pdo, 'biography, profile_image', 'user_profiles', 'user_id', $userId);

?>

<article class="settings">
    <h1>Settings</h1>
    <?php foreach ($errors as $error) : ?>
        <div class="error">
            <?php echo $error; ?>
        </div><!-- /alert -->
    <?php endforeach; ?>
    <?php foreach ($messages as $message) : ?>
        <div class="message">
            <?php echo $message; ?>
        </div><!-- /alert -->
    <?php endforeach; ?>

    <form action="app/users/edit-settings.php" method="post" enctype="multipart/form-data" id="profile">
        <label for="image">Choose an image to upload</label>
        <input type="file" name="profile-image" id="image" class="choose-file">

        <!--Preview profile image -->
        <img class="preview-profile-image" src="/<?php echo $userProfile['profile_image'] ? 'uploads/' . $userProfile['profile_image'] : 'images/profile-picture.png' ?>" id="output-image" alt="image preview" />

        <small>Write your biography.</small>
        <textarea class="bio-textarea" name="biography" form="profile" maxlength="255"><?php echo ($userProfile !== null) ? $userProfile['biography'] : '' ?></textarea>
        <button type="submit" class="button">Upload</button>
    </form>

    <form action="app/users/edit-settings.php" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="<?php echo $_SESSION['user']['email'] ?>">
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="first-name">First name</label>
            <input type="name" name="first-name" value="<?php echo $_SESSION['user']['first_name'] ?>">
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="last-name">Last name</label>
            <input type="name" name="last-name" value="<?php echo $_SESSION['user']['last_name'] ?>">
        </div><!-- /form-group -->
        <button type="submit" class="button">Update info</button>
    </form>

    <form action="app/users/edit-settings.php" method="post">
        <div class="form-group">
            <label for="password">Current password</label>
            <input type="password" name="current-password" required>
            <small>Please provide your current password to be able to change to a new one.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="password">New password</label>
            <input type="password" name="password">
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="password">Confirm new password</label>
            <input type="password" name="confirm-password">
        </div><!-- /form-group -->
        <button type="submit" class="button">Update password</button>
    </form>
</article>

<?php require __DIR__ . '/views/bottom-bar.php'; ?>
<?php require __DIR__ . '/views/footer.php'; ?>
