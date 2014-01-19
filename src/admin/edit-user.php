<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once '../includes/edit-user.inc.php';

sec_session_start();

// If user is not logged in, redirect to login page
if (!login_check($mysqli)) {
    header('Location: ../login.php');
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Admin - Edit User</title>

        <!-- Bootstrap core CSS -->
        <link href="../styles/css/bootstrap.css" rel="stylesheet">
        <!-- Custom styles for login/registration page -->
        <link href="../styles/css/signin.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="../styles/css/navbar-fixed-top.css" rel="stylesheet">

        <script type="text/JavaScript" src="../js/sha512.js"></script>
        <script type="text/JavaScript" src="../js/forms.js"></script>
    </head>
    <body>

        <?php include 'admin_menu.php';?>

        <div class="container">
            <?php
                if (!empty($error_msg)) {
                    echo '<div class="alert alert-danger">';
                        echo $error_msg;
                    echo '</div>';
                }
            ?>


            <?php
                $prep_stmt = 'SELECT email FROM members WHERE id = ?';

                if ($stmt = $mysqli->prepare($prep_stmt)) {
                    $stmt->bind_param('i', $_GET['id']);
                    $stmt->execute();
                    $stmt->bind_result($email);
                    $stmt->fetch();
                }
            ?>

            <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' class="form-signin" method="post">

                <h1 class="form-signin-heading">Edit User</h1>
                <ul>
                    <li>Passwords must be at least 6 characters long</li>
                    <li>Passwords must contain
                        <ul>
                            <li>At least one upper case letter (A..Z)</li>
                            <li>At least one lower case letter (a..z)</li>
                            <li>At least one number (0..9)</li>
                        </ul>
                    </li>
                    <li>Your password and confirmation must match exactly</li>
                </ul>
                <input type='hidden' name='id' value='<?php echo $_GET["id"];?>'>

                <input class="form-control"
                       type="text"
                       name="email"
                       id="email"
                       placeholder="Email Address"
                       value='<?php echo $email;?>'
                       disabled>
                <input class="form-control"
                       type="password"
                       name="password"
                       id="password"
                       placeholder="New Password"
                       autofocus>
                <input class="form-control"
                       type="password"
                       name="confirmpwd"
                       id="confirmpwd"
                       placeholder="Confirm Password">
                <input type="submit"
                       name="submit"
                       class="btn btn-lg btn-primary btn-block"
                       value="Update User"
                       onclick="return regformhash(this.form,
                                       this.form.email,
                                       this.form.password,
                                       this.form.confirmpwd);">
            </form>
        </div>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="../styles/js/bootstrap.min.js"></script>

    </body>
</html>
