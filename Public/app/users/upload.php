<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_FILES['image'], $_POST['description'], $_SESSION['user'])) {
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $userId = $_SESSION['user']['id'];
    $messages = [];

    $newFileName = uploadFiles($_FILES['image'], '/upload.php');

    //Insert image and description to the posts table with the user's id.
    $query = 'INSERT INTO posts (image, description, user_id, date) VALUES (:image, :description, :user_id, :date)';

    $statement = $pdo->prepare($query);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':image', $newFileName, PDO::PARAM_STR);
    $statement->bindParam(':description', $description, PDO::PARAM_STR);
    $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $statement->bindParam(':date', date('d-m-Y, H:i:s'), PDO::PARAM_STR);
    $statement->execute();

    $messages[] = "Your post have been successfully uploaded!";

    $_SESSION['messages'] = $messages;
}

redirect('/upload.php');
