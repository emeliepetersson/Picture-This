<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$errors = [];
$messages = [];

//In this file we edit the users information.

//Change profile picture and biography
if (isset($_FILES['profile-image'], $_POST['biography'])) {
    $biography = filter_var($_POST['biography'], FILTER_SANITIZE_STRING);
    $userId = (string) $_SESSION['user']['id']; //convert user id into string to be able to use it in the functions to get data from table

    $profileExist = getOneColumnFromTable($pdo, '*', 'user_profiles', 'user_id', $userId);

    //If no new profile image is set, only add the biography to the database
    if ($_FILES['profile-image']['name'] === "" && $biography !== "") {
        if ($profileExist) {
            //Update biography in user_profiles where user_id is the same as the logged in user's id
            $statement = $pdo->prepare('UPDATE user_profiles SET biography = :biography WHERE user_id = :user_id');

            if (!$statement) {
                die(var_dump($pdo->errorInfo()));
            }

            $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $statement->bindParam(':biography', $biography, PDO::PARAM_STR);
            $statement->execute();
        } else {
            //Insert biography into user_profiles with user ID
            $query = 'INSERT INTO user_profiles (user_id, biography) VALUES (:user_id, :biography)';

            $statement = $pdo->prepare($query);

            if (!$statement) {
                die(var_dump($pdo->errorInfo()));
            }

            $statement->bindParam(':user_id', $_SESSION['user']['id'], PDO::PARAM_INT);
            $statement->bindParam(':biography', $biography, PDO::PARAM_STR);
            $statement->execute();
        }
    } else {
        $newFileName = uploadFiles($_FILES['profile-image'], '/settings.php');
        if ($profileExist) {
            //First we delete the previous profile image from the uploads folder
            $statementOne = $pdo->prepare("SELECT profile_image FROM user_profiles WHERE user_id = :user_id");
            if (!$statementOne) {
                die(var_dump($pdo->errorInfo()));
            }
            $statementOne->bindParam(':user_id', $userId, PDO::PARAM_STR);
            $statementOne->execute();
            $profileImage = $statementOne->fetch(PDO::FETCH_ASSOC);

            if ($profileImage !== false) {
                $path = '../../uploads/' . $profileImage['profile_image'];
                unlink($path);
            }

            //Then we update filname and biography
            $statementTwo = $pdo->prepare('UPDATE user_profiles SET biography = :biography, profile_image = :profile_image WHERE user_id = :user_id');

            if (!$statementTwo) {
                die(var_dump($pdo->errorInfo()));
            }

            $statementTwo->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $statementTwo->bindParam(':biography', $biography, PDO::PARAM_STR);
            $statementTwo->bindParam(':profile_image', $newFileName, PDO::PARAM_STR);
            $statementTwo->execute();
        } else {
            //Insert filname and biography into user_profiles with user ID
            $query = 'INSERT INTO user_profiles (user_id, biography, profile_image) VALUES (:user_id, :biography, :profile_image)';

            $statement = $pdo->prepare($query);

            if (!$statement) {
                die(var_dump($pdo->errorInfo()));
            }

            $statement->bindParam(':user_id', $_SESSION['user']['id'], PDO::PARAM_INT);
            $statement->bindParam(':biography', $biography, PDO::PARAM_STR);
            $statement->bindParam(':profile_image', $newFileName, PDO::PARAM_STR);
            $statement->execute();
        }
    }

    $messages[] = "Your profile have been updated!";

    $_SESSION['messages'] = $messages;
}


//Change email, first name and last name
if (isset($_POST['email'], $_POST['first-name'], $_POST['last-name'])) {
    $email = $_POST['email'];
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];

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


redirect('/settings.php');

// if there is no such row, INSERT a new one.
