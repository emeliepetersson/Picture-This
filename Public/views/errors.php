<?php

$errors = [];

if (isset($_SESSION['errors'])) {
    // First we fetch the errors from the session and then we remove them. If we
    // keep them in the session the error messsages will reappear even when we
    // reload the page or resubmit the form.
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}
