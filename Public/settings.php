<?php
require __DIR__ . '/views/header.php';

isLoggedIn();

$userId = (string) $_SESSION['user']['id']; //convert user id into string to be able to use it in the function to get data from table
$userProfile = getOneColumnFromTable($pdo, 'biography, profile_image', 'user_profiles', 'user_id', $userId);

?>
<div class="background"></div>

<article class="settings">
    <h1>Settings</h1>

    <?php require __DIR__ . '/views/errors.php'; ?>
    <?php require __DIR__ . '/views/messages.php'; ?>

    <form action="app/users/edit-settings.php" method="post" enctype="multipart/form-data" id="profile">
        <label for="image">Choose an image to upload</label>
        <input type="file" name="profile-image" id="image" class="choose-file">

        <!--Preview profile image -->
        <img class="preview-profile-image" src="/<?php echo $userProfile['profile_image'] ? 'uploads/' . $userProfile['profile_image'] : 'images/profile-picture.png' ?>" id="output-image" alt="image preview" loading="lazy" />

        <small>Write your biography.</small>
        <textarea class="bio-textarea" name="biography" form="profile" maxlength="255"><?php echo ($userProfile !== null) ? $userProfile['biography'] : '' ?></textarea>
        <button type="submit" class="button">Upload</button>
    </form>

    <form action="app/users/edit-settings.php" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="<?php echo $_SESSION['user']['email'] ?>">
        </div>

        <div class="form-group">
            <label for="first-name">First name</label>
            <input type="name" name="first-name" value="<?php echo $_SESSION['user']['first_name'] ?>">
        </div>

        <div class="form-group">
            <label for="last-name">Last name</label>
            <input type="name" name="last-name" value="<?php echo $_SESSION['user']['last_name'] ?>">
        </div>
        <button type="submit" class="button">Update info</button>
    </form>

    <form action="app/users/edit-settings.php" method="post">
        <div class="form-group">
            <label for="password">Current password</label>
            <input type="password" name="current-password" required>
            <small>Please provide your current password to be able to change to a new one.</small>
        </div>

        <div class="form-group">
            <label for="password">New password</label>
            <input type="password" name="password">
        </div>

        <div class="form-group">
            <label for="password">Confirm new password</label>
            <input type="password" name="confirm-password">
        </div>
        <button type="submit" class="button">Update password</button>
    </form>

    <button type="button" class="button delete-account-button">Delete Account</button>
    <form class="delete-account-form" action="app/users/delete-account.php" method="post">
        <p>Are you sure you want to delete your account?</p>
        <button type="button" class="button small-button cancel-delete-account">Cancel</button>
        <button type="submit" class="button small-button delete-account-button">Delete</button>
    </form>
</article>

<?php require __DIR__ . '/views/bottom-bar.php'; ?>
<?php require __DIR__ . '/views/footer.php'; ?>
