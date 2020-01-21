<?php require __DIR__ . '/views/header.php'; ?>
<?php isLoggedIn(); ?>

<article>


    <?php require __DIR__ . '/views/messages.php'; ?>

    <div class="form-group">
        <input type="search" name="search" class="search-input" placeholder="Enter search here." autocomplete="off">
    </div>

    <div class="background"></div>
    <div class="explore-container search-results"></div>

</article>

<?php require __DIR__ . '/views/bottom-bar.php'; ?>
<?php require __DIR__ . '/views/footer.php'; ?>