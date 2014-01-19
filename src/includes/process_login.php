<?php
include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST["email"];
    $password = $_POST['p']; // Hashed password

    switch (login($email, $password, $mysqli)) {
        case "login":
            header('Location: ../index.php?message=login');
            break;
        case "wrong_password":
            header('Location: ../login.php?error=1');
            break;
        case "no_user":
            header('Location: ../login.php?error=2');
            break;
        default:
            header('Location: ../login.php?error=Error');
    }

    /*if (login($email, $password, $mysqli) == true) {
        // Login success
        header('Location: ../index.php?message=login');
    } else {
        // Login failed
        header('Location: ../login.php?error=1');
    }*/
} else {
    // The correct POST variables were not sent to this page.
    echo 'Invalid Request';
}
?>
