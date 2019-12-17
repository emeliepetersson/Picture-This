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
}

redirect('/settings.php');

// if there is no such row, INSERT a new one.
