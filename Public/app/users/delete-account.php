<?php


declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$messages = [];

if (isset($_SESSION['user'])) {
    $userId = (int) filter_var($_SESSION['user']['id'], FILTER_SANITIZE_NUMBER_INT);


    //Delete user's profile image in uploads folder
    $statement = $pdo->prepare("SELECT profile_image FROM user_profiles WHERE user_id = :user_id");
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':user_id', $userId, PDO::PARAM_STR);
    $statement->execute();
    $profileImage = $statement->fetch(PDO::FETCH_ASSOC);

    if ($profileImage !== false) {
        $path = '../../uploads/' . $profileImage['profile_image'];
        unlink($path);
    }

    //Delete post images from user in uploads folder
    $statement = $pdo->prepare("SELECT image FROM posts WHERE user_id = :user_id");
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':user_id', $userId, PDO::PARAM_STR);
    $statement->execute();
    $images = $statement->fetchAll(PDO::FETCH_ASSOC);


    if (count($images) > 0) {
        foreach ($images as $image) {
            $path = '../../uploads/' . $image['image'];
            unlink($path);
        }
    }

    // Delete from users table
    $statementOne = $pdo->prepare('DELETE FROM users WHERE id = :id');
    if (!$statementOne) {
        die(var_dump($pdo->errorInfo()));
    }
    $statementOne->bindParam(':id', $userId, PDO::PARAM_INT);
    $statementOne->execute();

    // Delete from followers table
    $statementTwo = $pdo->prepare('DELETE FROM followers WHERE user_id = :user_id OR following_user_id = :following_user_id');
    if (!$statementTwo) {
        die(var_dump($pdo->errorInfo()));
    }
    $statementTwo->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $statementTwo->bindParam(':following_user_id', $userId, PDO::PARAM_INT);
    $statementTwo->execute();

    // Delete from likes table
    $statementThree = $pdo->prepare('DELETE FROM likes WHERE user_id = :user_id');
    if (!$statementThree) {
        die(var_dump($pdo->errorInfo()));
    }
    $statementThree->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $statementThree->execute();

    // Delete from posts table
    $statementFour = $pdo->prepare('DELETE FROM posts WHERE user_id = :user_id');
    if (!$statementFour) {
        die(var_dump($pdo->errorInfo()));
    }
    $statementFour->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $statementFour->execute();

    // Delete from user_profiles table
    $statementFive = $pdo->prepare('DELETE FROM user_profiles WHERE user_id = :user_id');
    if (!$statementFive) {
        die(var_dump($pdo->errorInfo()));
    }
    $statementFive->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $statementFive->execute();

    // Delete from comments table
    $statementFive = $pdo->prepare('DELETE FROM comments WHERE user_id = :user_id');
    if (!$statementFive) {
        die(var_dump($pdo->errorInfo()));
    }
    $statementFive->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $statementFive->execute();

    $messages[] = "Your account has been deleted!";

    $_SESSION['messages'] = $messages;

    // unset $_SESSION['user']
    unset($_SESSION['user']);
}

redirect('/');
