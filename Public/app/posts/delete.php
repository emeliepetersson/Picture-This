<?php



declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we delete posts in the database.

if (isset($_POST['post-id'], $_POST['post-name'], $_SESSION['user'])) {
    $postId = filter_var($_POST['post-id'], FILTER_SANITIZE_STRING);
    $postName = filter_var($_POST['post-name'], FILTER_SANITIZE_STRING);
    $userId = (int) $_SESSION['user']['id'];

    $statement = $pdo->prepare('DELETE FROM posts where id = :id AND user_id = :user_id');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':id', $postId, PDO::PARAM_STR);
    $statement->bindParam(':user_id', $userId, PDO::PARAM_STR);
    $statement->execute();

    $path = '../../uploads/' . $postName;
    unlink($path);
}

redirect('/profile.php');
