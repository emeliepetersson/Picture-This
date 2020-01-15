<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

//In this file we sign up users.

if (isset($_POST['email'], $_POST['first-name'], $_POST['last-name'], $_POST['password'], $_POST['confirm-password'])) {
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $firstName = trim(filter_var($_POST['first-name'], FILTER_SANITIZE_STRING));
    $lastName = trim(filter_var($_POST['last-name'], FILTER_SANITIZE_STRING));
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];
    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'The email address is not a valid email address!';
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Your passwords do not match!";
    } else {
        $password = password_hash($password, PASSWORD_BCRYPT);
    }

    $emailExist = getDataAsArrayFromTable($pdo, 'email', 'users', 'email', $email);

    if ($emailExist) { //If $emailExist exists an error message will be printed
        $errors[] = "The email already exist!";
    }

    countErrors('/signup.php', $errors);


    // If email doesn't already exist, insert the data into the user table.
    $query = 'INSERT INTO users (email, first_name, last_name, password) VALUES (:email, :first_name, :last_name, :password)';

    $statement = $pdo->prepare($query);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':first_name', $firstName, PDO::PARAM_STR);
    $statement->bindParam(':last_name', $lastName, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);
    $statement->execute();

    // Get new user's ID in users table
    $statementTwo = $pdo->prepare("SELECT id FROM users WHERE email = :email");

    if (!$statementTwo) {
        die(var_dump($pdo->errorInfo()));
    }

    $statementTwo->bindParam(':email', $email, PDO::PARAM_STR);
    $statementTwo->execute();
    $userId = $statementTwo->fetch(PDO::FETCH_ASSOC);

    // Insert user into user_profiles with default values
    $statementThree = $pdo->prepare("INSERT INTO user_profiles (user_id, biography, profile_image) VALUES (:user_id, '', '')");

    if (!$statementThree) {
        die(var_dump($pdo->errorInfo()));
    }

    $statementThree->bindParam(':user_id', $userId['id'], PDO::PARAM_STR);
    $statementThree->execute();
}

redirect('/login.php');
