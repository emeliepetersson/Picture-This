<?php



declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// here we get all comments on a post

isLoggedIn();

if (isset($_POST['post_id'], $_SESSION['user'])) {
    $postId = filter_var(trim($_POST['post_id']), FILTER_SANITIZE_NUMBER_INT);
    $userId = $_SESSION['user']['id'];
    $comments = [];
    $commentsWithUsers = [];

    $post = getDataAsArrayFromTable($pdo, "id", "posts", "id", $postId);

    if ($post) {
        $comments = getDataAsArrayFromTable($pdo, "*", "comments", "post_id", $postId);

        foreach ($comments as $comment) {
            $query = "SELECT first_name, last_name, user_profiles.profile_image
            FROM users
            INNER JOIN user_profiles ON users.id = user_profiles.user_id
            WHERE users.id = :id";

            $statement = $pdo->prepare($query);
            if (!$statement) {
                die(var_dump($pdo->errorInfo()));
            }
            $statement->bindParam(':id', $comment['user_id'], PDO::PARAM_INT);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            $comment['profile_url'] = '/user-profiles.php?user-id=';
            if ((int) $comment['user_id'] === $userId) {
                $comment['profile_url'] = '/profile.php';
            }

            $comment['first_name'] = $user['first_name'];
            $comment['last_name'] = $user['last_name'];
            $comment['profile_image'] = $user['profile_image'];
            $commentsWithUsers[] = $comment;
        }

        echo json_encode($commentsWithUsers);
    } else {
        echo json_encode("Post not found.");
    }
} else {
    redirect('/');
}
