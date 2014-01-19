<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Secure Login: Log In</title>

        <!-- Bootstrap core CSS -->
        <link href="styles/css/bootstrap.css" rel="stylesheet">
        <!-- Custom styles for login/registration page -->
        <link href="styles/css/signin.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="styles/css/navbar-fixed-top.css" rel="stylesheet">

        <script type="text/JavaScript" src="js/sha512.js"></script>
        <script type="text/JavaScript" src="js/forms.js"></script>
    </head>
    <body>
        <?php include 'menu.php';?>

        <div class="container">
            <?php
                if (isset($_GET['error'])) {
                    echo '<div class="alert alert-danger">';
                        switch ($_GET['error']) {
                                case "1":
                                    echo 'Error Logging In!';
                                    break;
                                case "2":
                                    echo 'No such user!';
                                    break;
                                default:
                                    echo $_GET['error'];
                            }
                    echo '</div>';
                }

                if (login_check($mysqli) == true) :
                    header('Location: index.php');
                else :
            ?>
            <form class="form-signin" action="includes/process_login.php" method="post" name="login_form">
                <h2 class="form-signin-heading">Please sign in</h2>
                <input class="form-control"
                       type="text"
                       name="email"
                       placeholder="Email Address"
                       required
                       autofocus>
                <input class="form-control"
                       type="password"
                       name="password"
                       id="password"
                       placeholder="Password"
                       required>
                <input type="button"
                       class="btn btn-lg btn-primary btn-block"
                       value="Login"
                       onclick="return formhash(this.form, this.form.password);">
                <p>If you don't have a login, please <a href="register.php">register</a></p>
            </form>
            <?php endif; ?>
        </div>
    </body>
</html>
