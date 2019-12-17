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
function getDataFromTable(PDO $pdo, string $columns, string $table, string $column, string $value): ?array
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

function countErrors(string $location, array $errors): void
{
    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        redirect($location);
        exit;
    }
}

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
