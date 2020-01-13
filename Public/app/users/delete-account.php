<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$messages = [];

if (isset($_POST['user-id'])) {
    $userId = (int) trim(filter_var($_POST['user-id'], FILTER_SANITIZE_NUMBER_INT));

    //Delete post images from user in uploads folder

    // $statement = $pdo->prepare("SELECT image FROM posts WHERE user_id = :user_id");
    // if (!$statement) {
    //     die(var_dump($pdo->errorInfo()));
    // }
    // $statement->bindParam(':user_id', $userId, PDO::PARAM_STR);
    // $statement->execute();
    // $images = $statement->fetchAll(PDO::FETCH_ASSOC);

    // if (count($images) > 0)
    //     foreach ($images as $image) {
    //         $path = '../../uploads/' . $image['image'];
    //         unlink($path);
    //     }


    //Delet user from all tables

    // $statement = $pdo->prepare('DELETE FROM users WHERE id = :id');
    // if (!$statement) {
    //     die(var_dump($pdo->errorInfo()));
    // }
    // $statement->bindParam(':id', $userId, PDO::PARAM_STR);
    // $statement->execute();

    $statement = $pdo->prepare('DELETE FROM users
    INNER JOIN comments
    ON users.id = comments.user_id
    INNER JOIN followers
    ON users.id = followers.user_id
    AND users.id = followers.following_user_id
    INNER JOIN likes
    ON users.id = likes.user_id
    INNER JOIN posts
    ON users.id = posts.uder_id
    INNER JOIN user_profiles
    ON users.id = user_profiles.user_id
    WHERE users.id = :id');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':id', $userId, PDO::PARAM_INT);
    $statement->execute();

    $messages[] = "Your account has been deleted!";

    $_SESSION['messages'] = $messages;

    // unset $_SESSION['user']
    unset($_SESSION['user']);
}

redirect('/');
