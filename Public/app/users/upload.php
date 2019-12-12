<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_FILES['image'], $_POST['description'])) {
    $image = $_FILES['image'];
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $errors = [];

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

    $destination = __DIR__ . '/../../uploads/' . uniqid() . $image['name'];
    move_uploaded_file($image['tmp_name'], $destination);


    //get user id with $_SESSION[], add $description and image file name to table with users id

}

redirect('/upload.php');
