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
    $query = 'SELECT posts.id, image, description, posts.user_id, date, first_name, last_name, user_profiles.profile_image
    FROM posts
    INNER JOIN users ON posts.user_id = users.id
    INNER JOIN user_profiles ON users.id = user_profiles.user_id
    WHERE description LIKE :query';
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
