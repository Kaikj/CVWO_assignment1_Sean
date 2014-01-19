<?php
    include_once '../includes/db_connect.php';
    include_once '../includes/functions.php';

    $error_msg = "";

    if (isset($_POST['submit'])) {
        $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
        if (strlen($password) != 128) {
            // The hashed pwd should be 128 characters long.
            // If it's not, something really odd has happened
            $error_msg .= '<br>Invalid password configuration.';
        }

        // Password validity have been checked client side.
        // This should should be adequate as nobody gains any advantage from
        // breaking these rules.

        if (empty($error_msg)) {
            // Create a random salt
            $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

            // Create salted password
            $password = hash('sha512', $password . $random_salt);

            // Update the user in the database
            if ($update_stmt = $mysqli->prepare("UPDATE members SET password = ?, salt = ? WHERE id = ?")) {
                $update_stmt->bind_param('ssi', $password, $random_salt, $_POST['id']);
                // Execute the prepared query.
                if (! $update_stmt->execute()) {
                    header('Location: ./users.php?error=edited');
                }

                header('Location: ./users.php?message=edited');
            }
        }
    }

?>
