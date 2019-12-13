<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we login users.

if (isset($_POST['email'], $_POST['password'])) {
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = $_POST['password'];

    $user = getDataFromTable($pdo, 'users', 'email', $email);

    // If the user isn't found in the database, redirect back to the login page.
    if (!$user || !password_verify($_POST['password'], $user['password'])) {
        $errors[] = "The email or password doesn't match!";
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
