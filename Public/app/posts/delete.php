<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we delete new posts in the database.

if (isset($_POST['post-id'], $_POST['post-name'])) {
    $postId = filter_var($_POST['post-id'], FILTER_SANITIZE_STRING);
    $postName = filter_var($_POST['post-name'], FILTER_SANITIZE_STRING);
    $statement = $pdo->prepare('DELETE FROM posts where id = :id');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':id', $postId, PDO::PARAM_STR);
    $statement->execute();

    $path = '../../uploads/' . $postName;
    unlink($path);
}

redirect('/profile.php');
