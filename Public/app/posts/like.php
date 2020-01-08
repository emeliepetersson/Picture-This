<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


// In this file we add likes to posts in the database.


if (isset($_GET['id'], $_GET['location'])) {

    if (isset($_GET['user-id'])) {
        $location = $_GET['location'] . "?user-id=" . $_GET['user-id'];
    } else {
        $location = $_GET['location'];
    }
    $postId = (int) trim(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));
    $userId = (int) $_SESSION['user']['id'];

    //Check if the user already has liked the photo
    $alreadyliked = getLikes($pdo, "post_id, user_id", "likes", "post_id", "user_id", $postId, $userId);

    //Check if the post exists
    $postExists = getDataAsArrayFromTable($pdo, 'id', 'posts', 'id', (string) $postId);

    //insert like into table if the user hasn't liked the photo
    if (!$alreadyliked && $postExists) {
        $statement = $pdo->prepare('INSERT INTO likes (post_id, user_id)
        VALUES (:post_id, :user_id)');

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $statement->bindParam(':user_id',  $_SESSION['user']['id'], PDO::PARAM_INT);
        $statement->execute();
    }
}

redirect('/' . $location);
