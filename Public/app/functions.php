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
 * Return array with biography and profile image of given user
 *
 * @param PDO $pdo
 * @param string $userId
 * @return array|null
 */
function getUserProfile(PDO $pdo, string $userId): ?array
{
    $profile = getOneColumnFromTable($pdo, 'biography, profile_image', 'user_profiles', 'user_id', $userId);
    return $profile;
}
