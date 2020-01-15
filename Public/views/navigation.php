<nav class="main-navbar">

    <!-- if the user is on index.php and is not logged in, then the logo won't show in the navbar -->
    <?php if ($_SERVER['SCRIPT_NAME'] !== '/index.php' || isset($_SESSION['user'])) : ?>
        <a href="/index.php"><img class="logo" src="<?php echo $config['logo']; ?>" alt="Picture this logo"></a>
    <?php endif; ?>

    <!-- Hamburger menu icon -->
    <div class="hamburger-icon">
        <div class="bar1"></div>
        <div class="bar2"></div>
    </div>

    <div class="menu">
        <div class="menu-items">
            <ul>
                <?php if (isset($_SESSION['user'])) : ?>
                    <li>
                        <a href="/profile.php">Profile</a>
                    </li>
                    <li>
                        <a href="/settings.php">Settings</a>
                    </li>
                    <li>
                        <a href="/upload.php">Upload post</a>
                    </li>
                    <li>
                        <a href="/app/users/logout.php">Logout</a>
                    </li>
                <?php else : ?>
                    <li>
                        <a href="/index.php">Home</a>
                    </li>
                    <li>
                        <a href="/about.php">About</a>
                    </li>
                    <li>
                        <a href="/login.php">Login</a>
                    </li>
                    <li>
                        <a href="/signup.php">Sign up</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav><!-- /navbar -->
