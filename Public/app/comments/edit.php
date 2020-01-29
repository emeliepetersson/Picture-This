<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// here we edit a comment

isLoggedIn();

if (isset($_POST['post-id'], $_POST['comment-id'], $_POST['content'], $_SESSION['user'])) {
    $commentId = filter_var($_POST['comment-id'], FILTER_SANITIZE_NUMBER_INT);
    $content = filter_var(trim($_POST['content']), FILTER_SANITIZE_STRING);
    $postId = filter_var($_POST['post-id'], FILTER_SANITIZE_NUMBER_INT);
    $userId = $_SESSION['user']['id'];

    if ($content === "") {
        $messages[] = "The comment can't be empty.";
        $_SESSION['messages'] = $messages;
        redirect('/comments.php?post=' . $postId);
    }

    $statement = $pdo->prepare('UPDATE comments 
    SET content = :content 
    where id = :id AND user_id = :user_id AND post_id = :post_id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':id', $commentId, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
    $statement->bindParam(':content', $content, PDO::PARAM_STR);
    $statement->execute();
} else {
    redirect('/');
}
