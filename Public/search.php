<?php require __DIR__ . '/views/header.php'; ?>
<?php isLoggedIn(); ?>

<article>


    <?php require __DIR__ . '/views/errors.php'; ?>

    <div class="form-group">
        <input type="search" name="search" class="search-input" placeholder="Enter search here." autocomplete="off">
    </div>

    <div class="search-results"></div>

</article>

<?php require __DIR__ . '/views/bottom-bar.php'; ?>

<script src="assets/scripts/search.js"></script>

<?php require __DIR__ . '/views/footer.php'; ?>