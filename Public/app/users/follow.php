<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// In this file users follow users

if (isset($_POST['user-id'], $_SESSION['user'])) {
    $followUserId = (int) trim(filter_var($_POST['user-id'], FILTER_SANITIZE_NUMBER_INT));
    $userId = (int) $_SESSION['user']['id'];
    $errors = [];

    //First check if the user already follows the other user
    $userAlreadyFollow = getDataWithTwoConditions($pdo, 'user_id, following_user_id', 'followers', 'user_id', 'following_user_id', $userId, $followUserId);

    //If the user do follow the other user display an error message
    if ($userAlreadyFollow) {
        $errors[] = 'You already follow this user!';
        countErrors('/user-profiles.php?user-id='.$_POST['user-id'], $errors);
    } else {
        $query = 'INSERT INTO followers (user_id, following_user_id)
        VALUES (:user_id, :following_user_id)';

        $statement = $pdo->prepare($query);

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindParam(':following_user_id', $followUserId, PDO::PARAM_INT);
        $statement->execute();

        $messages[] = 'You are now following this user!';

        if (count($messages) > 0) {
            $_SESSION['messages'] = $messages;
        }
    }
}

redirect('/user-profiles.php?user-id='.$_POST['user-id']);
