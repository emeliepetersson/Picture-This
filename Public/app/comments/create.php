<?php


declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// here we add a comment to a post

isLoggedIn();

if (isset($_POST['content'], $_POST['post_id'], $_SESSION['user'])) {
    $content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
    $postId = filter_var($_POST['post_id'], FILTER_SANITIZE_NUMBER_INT);
    $userId = $_SESSION['user']['id'];
    $date = date('d-m-Y, H:i:s');

    $query = 'INSERT INTO comments (post_id, user_id, date, content) VALUES (:post_id, :user_id, :date, :content )';

    $statement = $pdo->prepare($query);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $statement->bindParam(':date', $date, PDO::PARAM_STR);
    $statement->bindParam(':content', $content, PDO::PARAM_STR);

    $statement->execute();
} else {
    redirect('/');
}
