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
 * return an array with data from a given table.
 *
 * @param PDO $pdo
 * @param string $table
 * @param string $column
 * @param string $value
 * @return array
 */
function getDataFromTable(PDO $pdo, string $table, string $column, string $value): array
{
    $statement = $pdo->prepare("SELECT * FROM $table WHERE $column = :$column");
    $statement->bindParam(":$column", $value, PDO::PARAM_STR);
    $statement->execute();

    $array = $statement->fetch(PDO::FETCH_ASSOC);
    return $array;
}
