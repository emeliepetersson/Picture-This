<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

isLoggedIn();

// here we search for posts in the database

if (isset($_POST['search'])) {
    $search = trim(filter_var($_POST['search'], FILTER_SANITIZE_STRING));
    $usersPosts = [];

    if (empty($search)) {
        echo json_encode('No posts found');
        exit;
    }
    $query = 'SELECT id FROM users
    WHERE first_name LIKE :query
    OR last_name LIKE :query';
    $statement = $pdo->prepare($query);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        'query' => "%" . $search . "%",
    ]);
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    // do something here to get likes for posts and attach to the post and send as json to js
    foreach ($users as $user) {
        $userPosts = displayPostsFromUser($pdo, (int) $user['id']);
        if (count($userPosts) === 0) {
            continue;
        }
        $usersPosts[] = $userPosts;
    }

    header('Content-Type: application/json');
    echo json_encode($usersPosts);
} else {
    redirect('/');
}
