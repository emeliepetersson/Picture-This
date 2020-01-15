<?php


declare(strict_types=1);

if (!function_exists('redirect')) {
    /**
     * Redirect the user to given path.
     *
     * @param string $path
     *
     * @return void
     */
    function redirect(string $path)
    {
        header("Location: ${path}");
        exit;
    }
}

/**
 * return an array with data from a given table, or null if the data isn't found.
 *
 * @param PDO $pdo
 * @param string $columns
 * @param string $table
 * @param string $column
 * @param string $value
 * @return array|null
 */
function getDataAsArrayFromTable(PDO $pdo, string $columns, string $table, string $column, string $value): ?array
{
    $statement = $pdo->prepare("SELECT $columns FROM $table WHERE $column = :$column");
    if (!$statement) {
        return die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(":$column", $value, PDO::PARAM_STR);
    $statement->execute();

    $array = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($array === false) {
        return null;
    }

    return $array;
}

/**
 * return an array with data from one given column in table, or null if the data isn't found.
 *
 * @param PDO $pdo
 * @param string $columns
 * @param string $table
 * @param string $column
 * @param string $value
 * @return array|null
 */
function getOneColumnFromTable(PDO $pdo, string $columns, string $table, string $column, string $value): ?array
{
    $statement = $pdo->prepare("SELECT $columns FROM $table WHERE $column = :$column");
    if (!$statement) {
        return die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(":$column", $value, PDO::PARAM_STR);
    $statement->execute();

    $column = $statement->fetch(PDO::FETCH_ASSOC);

    if ($column === false) {
        return null;
    }

    return $column;
}

/**
 * Set $_SESSION['errors'] and redirect to given location if there is any errors
 *
 * @param string $location
 * @param array $errors
 * @return void
 */
function countErrors(string $location, array $errors): void
{
    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        redirect($location);
        exit;
    }
}

/**
 * move uploaded file into Uploads directory, and return the new file name
 *
 * @param array $uploadedFile
 * @param string $location
 * @return string
 */
function uploadFiles(array $uploadedFile, string $location): string
{
    $file = $uploadedFile;
    $errors = [];

    if ($file['type'] !== 'image/gif' && $file['type'] !== 'image/jpeg' && $file['type'] !== 'image/png') {
        $errors[] = 'The ' . $file['name'] . ' image file type is not allowed.';
    }
    if ($file['size'] >= 3000000) {
        $errors[] = 'The uploaded file ' . $file['name'] . ' exceeded the filesize limit.';
    }

    countErrors($location, $errors);

    $newFileName = uniqid() . $file['name'];
    $destination = __DIR__ . '/../uploads/' .  $newFileName;
    move_uploaded_file($file['tmp_name'], $destination);

    return $newFileName;
}

/**
 * return array with data based on two conditions, or null if there is no data
 *
 * @param PDO $pdo
 * @param string $columns
 * @param string $table
 * @param string $conditionOne
 * @param string $conditionTwo
 * @param integer $valueOne
 * @param integer $valueTwo
 * @return array|null
 */
function getDataWithTwoConditions(PDO $pdo, string $columns, string $table, string $conditionOne, string $conditionTwo, int $valueOne, int $valueTwo): ?array
{
    $statement = $pdo->prepare("SELECT $columns FROM $table WHERE $conditionOne = :$conditionOne AND $conditionTwo = :$conditionTwo");

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(":$conditionOne", $valueOne, PDO::PARAM_INT);
    $statement->bindParam(":$conditionTwo", $valueTwo, PDO::PARAM_INT);
    $statement->execute();

    $data = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($data === false) {
        return null;
    }

    return $data;
}

/**
 * Return all posts from posts table
 *
 * @param PDO $pdo
 * @return array
 */
function displayPostsFromUser(PDO $pdo, int $userId): array
{
    $query = "SELECT posts.id, posts.user_id, image, description, date, first_name, last_name, user_profiles.profile_image
    FROM posts
    INNER JOIN users ON posts.user_id = users.id
    INNER JOIN user_profiles ON users.id = user_profiles.user_id
    WHERE users.id = :id";

    // Get all posts from logged in user
    $statement = $pdo->prepare($query);
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':id', $userId, PDO::PARAM_INT);
    $statement->execute();
    $userPosts = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $userPosts;
}

/**
 * Return all posts from logged in user
 *
 * @param PDO $pdo
 * @return array
 */
function displayAllPosts(PDO $pdo): array
{
    $query = "SELECT posts.id, image, description, date, first_name, last_name, posts.user_id, user_profiles.profile_image
    FROM posts
    INNER JOIN users ON posts.user_id = users.id
    INNER JOIN user_profiles ON users.id = user_profiles.user_id";

    // Get all posts from all users
    $statement = $pdo->query($query);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $allPosts = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $allPosts;
}

/**
 * return all followers or followings from tables
 *
 * @param PDO $pdo
 * @param string $condition
 * @param integer $value
 * @param string $join
 * @return array
 */
function getFollowers(PDO $pdo, string $condition, int $value, string $join): array
{
    $query = "SELECT user_id, following_user_id, first_name, last_name FROM followers
    INNER JOIN users ON followers.$join = users.id
    WHERE $condition = :$condition";

    // Get all posts from all users
    $statement = $pdo->query($query);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(":$condition", $value, PDO::PARAM_INT);
    $statement->execute();
    $followers = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $followers;
}

/**
 * Get all posts from people who the user follow
 *
 * @param Pdo $pdo
 * @return void
 */
function getFollowing(Pdo $pdo): array
{
    $query = "SELECT followers.user_id, following_user_id, first_name, last_name, posts.id, posts.user_id, posts.image, posts.description, posts.date, user_profiles.profile_image
    FROM followers
    INNER JOIN users ON following_user_id = users.id
    INNER JOIN posts ON users.id = posts.user_id
    INNER JOIN user_profiles ON users.id = user_profiles.user_id
    WHERE followers.user_id = :user_id";

    // Get all posts from all users
    $statement = $pdo->query($query);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(":user_id", $_SESSION['user']['id'], PDO::PARAM_INT);
    $statement->execute();
    $following = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $following;
}

/**
 * Function that checks if user is logged in, if not you will be redirected back to index page
 *
 * @return boolean
 */
function isLoggedIn()
{
    if (!isset($_SESSION['user'])) {
        redirect('/');
    }
}
