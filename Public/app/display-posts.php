<?php
require __DIR__ . '/autoload.php';
$posts = getDataFromTable($pdo, 'image, description, date', 'posts', 'user_id', $_SESSION['user']['id']);
die(var_dump($posts));
