<?php


declare(strict_types=1);

$messages = [];

if (isset($_SESSION['messages'])) {
    $messages = $_SESSION['messages'];
    unset($_SESSION['messages']);
}
