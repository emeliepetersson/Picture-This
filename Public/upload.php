<?php require __DIR__ . '/views/header.php'; ?>

<div class="upload-post">
    <h1>Upload post</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="image">Choose a image to upload</label>
        <input type="file" name="image" id="image" required>
        <button type="submit">Upload</button>
    </form>
</div>

<?php require __DIR__ . '/views/bottom-bar.php'; ?>
<?php require __DIR__ . '/views/footer.php'; ?>
