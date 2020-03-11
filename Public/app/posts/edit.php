<?php



declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we edit posts in the database.

if (isset($_POST['post-id'], $_POST['description'], $_SESSION['user'])) {
    $postId = filter_var($_POST['post-id'], FILTER_SANITIZE_NUMBER_INT);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $userId = $_SESSION['user']['id'];

    $statement = $pdo->prepare('UPDATE posts
    SET description = :description
    WHERE id = :id AND user_id = :user_id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':description', $description, PDO::PARAM_STR);
    $statement->bindParam(':id', $postId, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $statement->execute();

    $messages[] = "The post has been updated!";

    if (count($messages) > 0) {
        $_SESSION['messages'] = $messages;
    }
}

redirect('/profile.php');
