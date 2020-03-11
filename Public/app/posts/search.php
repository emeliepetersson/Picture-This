<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

isLoggedIn();

// here we search for users in the database and send back their posts

if (isset($_POST['search'])) {
    $search = trim(filter_var($_POST['search'], FILTER_SANITIZE_STRING));
    $userId = (int) $_SESSION['user']['id'];
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
        'query' => '%'.$search.'%',
    ]);
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        $userPosts = displayPostsFromUser($pdo, (int) $user['id']);
        if (count($userPosts) === 0) {
            continue;
        }

        foreach ($userPosts as $post) {
            $post['profile_url'] = '/user-profiles.php?user-id=';
            if ((int) $post['user_id'] === $userId) {
                $post['profile_url'] = '/profile.php';
            }

            $post['likes'] = count(getDataAsArrayFromTable($pdo, 'post_id', 'likes', 'post_id', (string) $post['id']));
            $alreadyLiked = getDataWithTwoConditions($pdo, 'post_id, user_id', 'likes', 'post_id', 'user_id', (int) $post['id'], $userId);

            $post['like'] = '';
            if ($alreadyLiked != null) {
                $post['like'] = 'liked';
            }
            $usersPosts[] = $post;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($usersPosts);
} else {
    redirect('/');
}
