<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a href="/index.php"><img src="<?php echo $config['logo']; ?>" alt="Picture this logo" width="40%"></a>

    <ul class="navbar-nav">



        <?php if (isset($_SESSION['user'])) : ?>
            <li class="nav-item">
                <a class="nav-link" href="/profile.php">Profile</a>
            </li><!-- /nav-item -->
            <li class="nav-item">
                <a class="nav-link" href="/settings.php">Settings</a>
            </li><!-- /nav-item -->
            <li class="nav-item">
                <a class="nav-link" href="/upload.php">Upload post</a>
            </li><!-- /nav-item -->
            <li class="nav-item">
                <a class="nav-link" href="/app/users/logout.php">Logout</a>
            </li><!-- /nav-item -->
        <?php else : ?>
            <li class="nav-item">
                <a class="nav-link" href="/index.php">Home</a>
            </li><!-- /nav-item -->
            <li class="nav-item">
                <a class="nav-link" href="/about.php">About</a>
            </li><!-- /nav-item -->
            <li class="nav-item">
                <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/login.php' ? 'active' : ''; ?>" href="login.php">Login</a>
            </li><!-- /nav-item -->
            <li class="nav-item">
                <a class="nav-link" href="/signup.php">Sign up</a>
            </li><!-- /nav-item -->
        <?php endif; ?>



    </ul><!-- /navbar-nav -->
</nav><!-- /navbar -->
