<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


// In this file we remove likes from posts in the database.


if (isset($_GET['id'], $_GET['location'], $_SESSION['user'])) {

    if (isset($_GET['user-id'])) {
        $location = $_GET['location'] . "?user-id=" . $_GET['user-id'];
    } else {
        $location = $_GET['location'];
    }
    $postId = trim(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));
    $userId = $_SESSION['user']['id'];

    //Check if the user already has liked the photo
    $alreadyliked = getDataWithTwoConditions($pdo, "post_id, user_id", "likes", "post_id", "user_id", (int) $postId, $userId);

    //Check if the post exists
    $postExists = getDataAsArrayFromTable($pdo, 'id', 'posts', 'id', (string) $postId);

    //insert like into table if the user hasn't liked the photo
    if ($alreadyliked && $postExists) {
        $statement = $pdo->prepare('DELETE FROM likes WHERE post_id = :post_id AND user_id = :user_id');

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $statement->execute();
    }
}
redirect('/' . $location);
