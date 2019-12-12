<?php require __DIR__ . '/views/header.php'; ?>

<div class="upload-post">
    <h1>Upload post</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data" id="post">
        <label for="image">Choose a image to upload</label>
        <input type="file" name="image" id="image" class="choose-file" required>

        <!--Preview image -->
        <img id="output-image" alt="image preview" />

        <button type="submit">Upload</button>
    </form>
    <textarea name="description" form="post" maxlength="255"></textarea>
</div>

<?php require __DIR__ . '/views/bottom-bar.php'; ?>
<?php require __DIR__ . '/views/footer.php'; ?>
