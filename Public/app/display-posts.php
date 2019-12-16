<?php

$query = "SELECT image, description, date, first_name, last_name FROM posts INNER JOIN users ON posts.user_id = users.id";

// Get all posts from logged in user
$statementOne = $pdo->prepare($query . " WHERE users.id = :id");
$statementOne->bindParam(':id', $_SESSION['user']['id'], PDO::PARAM_INT);
$statementOne->execute();
$userPosts = $statementOne->fetchAll(PDO::FETCH_ASSOC);


// Get all posts from all users
$statementTwo = $pdo->query($query);

if (!$statementTwo) {
    die(var_dump($pdo->errorInfo()));
}

$allPosts = $statementTwo->fetchAll(PDO::FETCH_ASSOC);
