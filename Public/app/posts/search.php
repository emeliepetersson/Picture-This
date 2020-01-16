<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

isLoggedIn();

// here we search for posts in the database

if (isset($_POST['search'])) {
    $search = trim(filter_var($_POST['search'], FILTER_SANITIZE_STRING));
    if (empty($search)) {
        echo json_encode('No posts found');
        exit;
    }
    $query = 'SELECT id, image, description, user_id, date FROM posts WHERE description LIKE :query';
    $statement = $pdo->prepare($query);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        'query' => "%" . $search . "%",
    ]);
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($posts);
} else {
    redirect('/');
}
