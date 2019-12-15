<?php
// $posts = getDataFromTable($pdo, 'image, description, date', 'posts', 'user_id', $_SESSION['user']['id']);

$statement = $pdo->query("SELECT image, description, date, first_name, last_name FROM posts INNER JOIN users ON posts.user_id = users.id");

if (!$statement) {
    die(var_dump($pdo->errorInfo()));
}

$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
