<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we delete posts in the database.

if (isset($_POST['description'], $_GET['post-id'])) {
    //DELETE from where post-id AND user-id! Otherwise error message
}

redirect('/');
