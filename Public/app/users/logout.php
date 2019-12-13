<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isset($_SESSION['user'])) { // Make this into a function!!!
    redirect('/');
}

// In this file we logout users.

// Remove the user session variable and redirect the user back to the homepage.
unset($_SESSION['user']);

redirect('/');
