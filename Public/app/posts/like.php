<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


// In this file we add and remove likes to posts in the database.


if (isset($_POST['post-id'], $_SESSION['user'])) {
    $postId = (int) trim(filter_var($_POST['post-id'], FILTER_SANITIZE_NUMBER_INT));
    $userId = (int) $_SESSION['user']['id'];

    //Check if the user already has liked the photo
    $alreadyliked = getDataWithTwoConditions($pdo, "post_id, user_id", "likes", "post_id", "user_id", $postId, $userId);

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
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $statement->execute();
    } else if ($alreadyliked && $postExists) {  //Delete like from table if the user has already liked the photo
        $statement = $pdo->prepare('DELETE FROM likes WHERE post_id = :post_id AND user_id = :user_id');

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $statement->execute();
    }

    // Get amount of likes and turn it into json
    $totalLikes = count(getDataAsArrayFromTable($pdo, "post_id", "likes", "post_id", (string) $postId));
    $totalLikes = json_encode($totalLikes);
    header('Content-Type: application/json');

    echo $totalLikes;
}
