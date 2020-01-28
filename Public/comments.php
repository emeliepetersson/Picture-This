<?php require __DIR__ . '/views/header.php'; ?>
<?php isLoggedIn(); ?>

<div class="comment-new">
    <label for="comment-content" hidden>Create comment</label>
    <input class="comment-content" name="comment-content" id="comment-content" type="text">
    <input type="hidden" name="user-id" id="user-id" value="<?php echo $_SESSION['user']['id'] ?>">
    <input type="hidden" name="post-id" id="post-id" value="<?php echo $_GET['post'] ?>">
    <button class="button smaller-button comment-submit">Submit comment</button>
</div>

<div class="comment-container"></div>

<?php require __DIR__ . '/views/bottom-bar.php'; ?>
<?php require __DIR__ . '/views/footer.php'; ?>