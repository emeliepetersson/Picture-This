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
    $statement->bindParam(":$column", $value, PDO::PARAM_STR);
    $statement->execute();

    $array = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($array === false) {
        return null;
    }

    return $array;
}
