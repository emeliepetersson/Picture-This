<?php

declare(strict_types=1);

$messages = [];

if (isset($_SESSION['messages'])) {
    // First we fetch the errors from the session and then we remove them. If we
    // keep them in the session the error messsages will reappear even when we
    // reload the page or resubmit the form.
    $messages = $_SESSION['messages'];
    unset($_SESSION['messages']);
}
