<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// here we add a comment to a post

isLoggedIn();

if (isset($_POST['comment'], $_POST['post_id'], $_SESSION['user'])) {
    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
    $postId = filter_var($_POST['post_id'], FILTER_SANITIZE_NUMBER_INT);
    $userId = $_SESSION['user']['id'];

    $query = 'INSERT INTO comments (post_id, user_id, comment, date) VALUES (:post_id, :user_id, :comment, :date)';

    $statement = $pdo->prepare($query);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $statement->bindParam(':comment', $comment, PDO::PARAM_STR);
    $statement->bindParam(':date', date('d-m-Y, H:i:s'), PDO::PARAM_STR);

    $statement->execute();

    $messages[] = "Your comment have been successfully posted!";

    $_SESSION['messages'] = $messages;
} else {
    redirect('/');
}
