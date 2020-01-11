<?php
// Always start by loading the default application setup.
require __DIR__ . '/../app/autoload.php';
require __DIR__ . '/../app/errors.php';
require __DIR__ . '/../app/messages.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Picture This</title>

    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://unpkg.com/sanitize.css">
    <link rel="stylesheet" href="/assets/styles/navigation.css">
    <link rel="stylesheet" href="/assets/styles/bottom-bar.css">
    <link rel="stylesheet" href="/assets/styles/post.css">
    <link rel="stylesheet" href="/assets/styles/upload-post.css">
    <link rel="stylesheet" href="/assets/styles/main.css">
    <link rel="stylesheet" href="/assets/styles/form.css">
    <link rel="stylesheet" href="/assets/styles/profile.css">
    <link rel="stylesheet" href="/assets/styles/settings.css">
    <link rel="stylesheet" href="/assets/styles/explore.css">
    <link href="https://fonts.googleapis.com/css?family=Chilanka|Gayathri|Raleway|Roboto&display=swap" rel="stylesheet">
</head>

<body>
    <?php require __DIR__ . '/navigation.php'; ?>

    <div class="container">
