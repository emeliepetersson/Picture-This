<nav class="main-navbar">
    <a href="/index.php"><img class="logo" src="<?php echo $config['logo']; ?>" alt="Picture this logo"></a>

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
                        <a class="nav-link" href="/profile.php">Profile</a>
                    </li><!-- /nav-item -->
                    <li>
                        <a class="nav-link" href="/settings.php">Settings</a>
                    </li><!-- /nav-item -->
                    <li>
                        <a class="nav-link" href="/upload.php">Upload post</a>
                    </li><!-- /nav-item -->
                    <li>
                        <a class="nav-link" href="/app/users/logout.php">Logout</a>
                    </li><!-- /nav-item -->
                <?php else : ?>
                    <li>
                        <a class="nav-link" href="/index.php">Home</a>
                    </li><!-- /nav-item -->
                    <li>
                        <a class="nav-link" href="/about.php">About</a>
                    </li><!-- /nav-item -->
                    <li>
                        <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/login.php' ? 'active' : ''; ?>" href="login.php">Login</a>
                    </li><!-- /nav-item -->
                    <li>
                        <a class="nav-link" href="/signup.php">Sign up</a>
                    </li><!-- /nav-item -->
                <?php endif; ?>
        </div>
    </div>


    </ul><!-- /navbar-nav -->
</nav><!-- /navbar -->
