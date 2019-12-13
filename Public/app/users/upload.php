<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_FILES['image'], $_POST['description'])) {
    $image = $_FILES['image'];
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $userId = $_SESSION['user']['id'];
    $errors = [];
    $messages = [];

    if ($image['type'] !== 'image/gif' && $image['type'] !== 'image/jpeg' && $image['type'] !== 'image/png') {
        $errors[] = 'The ' . $image['name'] . ' image file type is not allowed.';
    }
    if ($image['size'] >= 3000000) {
        $errors[] = 'The uploaded file ' . $image['name'] . ' exceeded the filesize limit.';
    }

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        redirect('/upload.php');
        exit;
    }

    $imageFileName = uniqid() . $image['name'];
    $destination = __DIR__ . '/../../uploads/' .  $imageFileName;
    move_uploaded_file($image['tmp_name'], $destination);


    //Insert image and description to the posts table with the user's id.
    $query = 'INSERT INTO posts (image, description, user_id, date) VALUES (:image, :description, :user_id, :date)';

    $statement = $pdo->prepare($query);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':image', $imageFileName, PDO::PARAM_STR);
    $statement->bindParam(':description', $description, PDO::PARAM_STR);
    $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $statement->bindParam(':date', date('d-m-Y, H:i:s'), PDO::PARAM_STR);
    $statement->execute();

    $messages[] = "Your post have been successfully uploaded!";

    $_SESSION['messages'] = $messages;
}

redirect('/upload.php');
