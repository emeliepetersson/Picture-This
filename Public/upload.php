<?php
require __DIR__ . '/views/header.php';
if (!isset($_SESSION['user'])) { // Make this into a function!!!
    redirect('/');
}
?>

<div class="upload-post">
    <h1>Upload post</h1>
    <!-- Is ID needed in form?? -->
    <form action="app/users/upload.php" method="post" enctype="multipart/form-data" id="post">
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
        <label for="image">Choose an image to upload</label>
        <input type="file" name="image" id="image" class="choose-file" required>

        <!--Preview image -->
        <div class="post-image">
            <img class="preview-image" src="/images/placeholder.png" id="output-image" alt="image preview" />
        </div>

        <label for="description">Write a caption</label>
        <textarea class="post-caption" name="description" form="post" maxlength="255"></textarea>
        <button class="button" type="submit">Upload</button>
    </form>
</div>

<?php require __DIR__ . '/views/bottom-bar.php'; ?>
<?php require __DIR__ . '/views/footer.php'; ?>
