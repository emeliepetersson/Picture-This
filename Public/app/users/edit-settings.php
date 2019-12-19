<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

//In this file we edit the users information.

// if isset UPDATE the new variables to the table columns where user id = $_SESSION['user']['id'].

//CHANGE FORM VALUES WHEN DATA IS UPDATED


//Change email, first name and last name
if (isset($_POST['email'], $_POST['first-name'], $_POST['last-name'])) {
    $email = $_POST['email'];
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $errors = [];

    $emailExist = getOneColumnFromTable($pdo, 'email', 'users', 'email', $email);

    $emailExist = implode($emailExist);

    if ($emailExist && $emailExist !== $_SESSION['user']['email']) { //If email already exists an error message will be printed
        $errors[] = "The email already exist!";
    }

    countErrors('/settings.php', $errors); //redirect to settings.php if there is any errors

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

    if (count($messages) > 0) {
        $_SESSION['messages'] = $messages;

        //update $_SESSION['user'] to match the new information about the user
        $user = getOneColumnFromTable($pdo, '*', 'users', 'email', $email);
        unset($user['password']); //Remove the password so that it won't be saved in the session variable.
        $_SESSION['user'] = $user;
    }
}


//Change password
if (isset($_POST['current-password'], $_POST['password'], $_POST['confirm-password'])) {
    $currentPassword = $_POST['current-password'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];
    $errors = [];

    $user = getOneColumnFromTable($pdo, '*', 'users', 'email', $_SESSION['user']['email']);

    if (password_verify($_POST['current-password'], $user['password'])) {

        if ($password !== $confirmPassword) { // ADD AS FUNCTION!?!?!? signup.php
            $errors[] = "Your passwords do not match!";
        } else {
            $password = password_hash($password, PASSWORD_BCRYPT);
        }

        countErrors('/settings.php', $errors); //redirect to settings.php if there is any errors


        $statement = $pdo->prepare('UPDATE users SET password = :password WHERE id = :id');

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->bindParam(':password', $password, PDO::PARAM_STR);
        $statement->bindParam(':id', $_SESSION['user']['id'], PDO::PARAM_INT);
        $statement->execute();

        $messages[] = "Your password has been updated!";

        $_SESSION['messages'] = $messages;
    } else {
        $errors[] = "You entered an incorrect password!";
        countErrors('/settings.php', $errors); //redirect to settings.php if there is any errors
    }
}

//Change profile picture and biography
if (isset($_POST['description'], $_FILES['image'])) {
    //insert $newFileName = uploadFiles($_FILES['image'], '/settings.php');
}

redirect('/settings.php');

// if there is no such row, INSERT a new one.
