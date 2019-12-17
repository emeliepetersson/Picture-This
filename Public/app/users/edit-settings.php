<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

//In this file we edit the users information.

// if isset UPDATE the new variables to the table columns where user id = $_SESSION['user']['id'].

//CHANGE FORM VALUES WHEN DATA IS UPDATED

if (isset($_POST['email'], $_POST['first-name'], $_POST['last-name'])) {
    $email = $_POST['email'];
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];


    $emailExist = getDataFromTable($pdo, 'email', 'users', 'email', $email);

    if ($emailExist) { //If $emailExist exists an error message will be printed
        $errors[] = "The email already exist!";
    }


    $statement = $pdo->prepare('UPDATE users
    SET email = :email, first_name = :first_name, last_name = :last_name
    WHERE id = :id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':first_name', $firstName, PDO::PARAM_STR);
    $statement->bindParam(':last_name', $lastName, PDO::PARAM_STR);
    $statement->bindParam(':id', $_SESSION['user']['id'], PDO::PARAM_INT);
    $statement->execute();

    $messages[] = "Your information has been updated!";

    $_SESSION['messages'] = $messages;
}

if (isset($_POST['password'], $_POST['confirm-password'])) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];


    if ($password !== $confirmPassword) { // ADD AS FUNCTION!?!?!? signup.php
        $errors[] = "Your passwords do not match!";
    } else {
        $password = password_hash($password, PASSWORD_BCRYPT);
    }


    $statement = $pdo->prepare('UPDATE users
    SET password = :password
    WHERE id = :id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':password', $password, PDO::PARAM_STR);
    $statement->bindParam(':id', $_SESSION['user']['id'], PDO::PARAM_INT);
    $statement->execute();

    $messages[] = "Your password has been updated!";

    $_SESSION['messages'] = $messages;
}

redirect('/settings.php');

// if there is no such row, INSERT a new one.
