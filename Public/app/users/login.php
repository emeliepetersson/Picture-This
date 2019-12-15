<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we login users.

if (isset($_POST['email'], $_POST['password'])) {
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = $_POST['password'];
    $errors = [];

    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $statement->bindParam(":email", $email, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);


    // If the user isn't found in the database, redirect back to the login page.
    if (!$user) {
        $errors[] = "The email adress do not exist!";
    } elseif (!password_verify($_POST['password'], $user['password'])) {
        $errors[] = "The password was not correct!";
    }

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        redirect('/login.php');
        exit;
    }

    // If the user is found in the database, compare the given password from the
    // request with the one in the database using the password_verify function.
    if (password_verify($_POST['password'], $user['password'])) {
        unset($user['password']); //Remove the password so that it won't be saved in the session variable.
        $_SESSION['user'] = $user;
    }
}

redirect('/');
